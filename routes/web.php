<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rank;
use App\Models\Permission;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
//use PHPUnit\Framework\Attributes\Ticket;
use App\Models\Ticket;
use App\Models\dialogue;
use App\Models\Dialogue as ModelsDialogue;
use App\Models\Facture;


// Generate PDF
use Barryvdh\DomPDF\Facade\Pdf;

function getPermission_navbar($user)
{
    $permissions = [];

    if ($user->hasPermission('view_tickets')) {
        $permissions[] = 'view_tickets';
    }

    if ($user->hasPermission('manage_users')) {
        $permissions[] = 'manage_users';
    }

    if ($user->hasPermission('view_storage')) {
        $permissions[] = 'view_storage';
    }

    if ($user->hasPermission('view_factures')) {
        $permissions[] = 'view_factures';
    }

    if ($user->hasPermission('view_settings')) {
        $permissions[] = 'view_settings';
    }

    return $permissions;
}


Route::get('/', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }

    $users = User::all()->count();
    $lastUser = User::latest()->first();
    // TODO: Récupérer les données d'activité depuis le paramètre
    // TODO: Récupérer le nombre de ticket à traiter et traité depuis tickets

    $permissions = getPermission_navbar($user);
    return view('welcome', compact('users', 'lastUser', 'permissions'));
});

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/')->withErrors(['email' => 'Vous êtes déjà connecté']);
    }

    return view('login');
});

Route::post('/login', function (Request $request) {
    if (Auth::check()) {
        return redirect('/')->withErrors(['email' => 'Vous êtes déjà connecté']);
    }

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user || !password_verify($request->password, $user->password)) {
        return back()->withErrors(['email' => 'Identifiants invalides']);
    }

    $user->remember_token = Str::random(60);
    $user->save();
    Auth::login($user);
    return redirect('/');
});

Route::get('/register', function () {
    if (Auth::check()) {
        return redirect('/')->withErrors(['email' => 'Vous êtes déjà connecté']);
    }

    return view('register');
});

Route::post('/register', function (Request $request) {
    if (Auth::check()) {
        return redirect('/')->withErrors(['email' => 'Vous êtes déjà connecté']);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $hasUser = User::where('email', $request->email)->orWhere('name', $request->name)->exists();
    if ($hasUser) {
        return back()->withErrors(['email' => 'Un utilisateur avec ce nom ou cet email existe déjà']);
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
    ]);

    return redirect('/login')->with('success', 'Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.');
});

Route::get('/logout', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour vous déconnecter']);
    }

    Auth::logout();
    return redirect('/login');
});

Route::get('/settings', function () {
    $user = Auth::user();
    if (!$user) return redirect('/login');

    if (!$user->hasPermission('view_settings')) {
        return redirect('/')->with('error', 'Accès refusé. Vous n avez pas la permission daccéder à cette page');
    }

    $roles = Rank::all();
    $permissions = getPermission_navbar($user);
    $allpermissions = Permission::all();
    return view('settings', compact('roles', 'permissions', 'allpermissions', 'user'));
});

Route::post('/settings', function (Request $request) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }

    if (!$user->hasPermission('view_settings') or !$user->hasPermission('create_settings')) {
        return redirect('/')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $request->validate([
        "nom" => "required|string|max:255|unique:ranks,name",
    ]);

    if ($request->nom === 'admin' || $request->nom === 'user') {
        return redirect('/settings')->withErrors(['nom' => 'Les rôles admin et user existent déjà et ne peuvent pas être créés']);
    }

    Rank::create([
        'name' => $request->nom,
        'priority' => 1000,
    ]);

    return redirect('/settings')->with('success', 'Le rôle a été créé avec succès.');
});

Route::post('/settings/droit', function (Request $request) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }

    $request->validate([
        'role_id' => 'required|exists:ranks,id',
        "permissions" => "required|array",
        "priority" => "required|integer|min:1|max:1000",
    ]);

    if (!$user->hasPermission('view_settings') or !$user->hasPermission('edit_settings')) {
        return redirect('/') - withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $role = Rank::find($request->role_id);
    if (!$role) {
        return redirect('/settings')->withErrors(['role_id' => 'Le rôle sélectionné est invalide']);
    }

    if (!$user->canTargetRole($role)) {
        return redirect('/settings')->withErrors(['role_id' => 'Vous ne pouvez pas cibler ce rôle']);
    }

    if ($user->getPriority() > $request->priority) {
        return redirect('/settings')->withErrors(['priority' => 'Vous ne pouvez pas attribuer une priorité inférieure à votre propre priorité']);
    }

    if ($role->name === 'admin') {
        return redirect('/settings')->withErrors(['role_id' => 'Les permissions du rôle admin ne peuvent pas être modifiées']);
    }

    $role->permissions()->detach();

    foreach ($request->permissions as $permissionName) {
        $permission = Permission::where('id', $permissionName)->first();
        if ($permission) {
            $role->permissions()->syncWithoutDetaching($permission->id);
        }
    }

    if ($request->priority !== null) {
        $role->priority = $request->priority;
        $role->save();
    }

    return redirect('/settings')->with('success', 'Les permissions ont été attribuées ou modifiées avec succès.');
});

Route::post('settings/supprimer', function (Request $request) {
    $blacklistRanks = ['admin', 'user']; // Rôles interdits pour la suppression
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }

    if (!$user->hasPermission('view_settings') or !$user->hasPermission('delete_settings')) {
        return redirect('/')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $request->validate([
        'role_id' => 'required|exists:ranks,id',
    ]);

    $role = Rank::find($request->role_id);
    if (!$role) {
        return redirect('/settings')->withErrors(['role_id' => 'Le rôle sélectionné est invalide']);
    }

    if (!$user->canTargetRole($role)) {
        return redirect('/settings')->withErrors(['role_id' => 'Vous ne pouvez pas supprimer ce rôle']);
    }

    if (in_array($role->name, $blacklistRanks)) {
        return redirect('/settings')->withErrors(['role_id' => 'Ce rôle ne peut pas être supprimé']);
    }

    $role->permissions()->detach();
    $role->delete();

    User::where('usergroup', $role->id)->update(['usergroup' => "user"]);

    return redirect('/settings')->with('success', 'Les droits ont été supprimés avec succès.');
});

function getAllTicket($user)
{
    if ($user->hasPermission('view_other_ticket')) {
        return Ticket::all();
    } else {
        return Ticket::where('user_id', $user->id)->get();
    }
}

$statusTicket = [
    "ouvert" => "Ouvert",
    "en_cours" => "En cours",
    "ferme" => "Fermé",
];

Route::get('/ticket', function () use ($statusTicket) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    if (!$user->hasPermission('view_tickets')) {
        return redirect('/')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $tickets = getAllTicket($user);
    $permissions = getPermission_navbar($user);

    return view('ticket', compact("user", "tickets", "permissions", "statusTicket"));
});

Route::post('/tickets', function (Request $request) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login') - withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    if (!$user->hasPermission('create_tickets')) {
        return redirect('/')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $request->validate([
        "description" => "required|string",
        "date_tiket" => "required",
    ]);

    Ticket::create([
        "description" => $request->description,
        "statut" => "ouvert",
        "date_tiket" => $request->date_tiket,
        "user_id" => $user->id
    ]);



    return redirect('/ticket')->with('success', 'Votre ticket a été créé avec succès. Vous pouvez maintenant le consulte voir mes tickes.');
});

Route::get('/ticket_dialogue', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login') - withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    if (!$user->hasPermission('view_tickets')) {
        return redirect('/')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $dialogue = Dialogue::all();

    if ($dialogue->user_id != $user->id and !$user->hasPermission('view_other_ticket')) {
        return redirect('/ticket')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $permissions = getPermission_navbar($user);

    return view('ticket_dialogue', compact("dialogue", "permissions"));
});

Route::post('/ticket_dialogue', function (Request $request) {

    $user = Auth::user();
    if (!$user) {
        return redirect('/login') - withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    if (!$user->hasPermission('view_tickets')) {
        return redirect('/')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $request->validate([
        "reponse" => "required|string|max:200",
        "ticket_id" => "required|exists:tickets,id",
    ]);

    $ticket = Ticket::find($request->ticket_id);
    if (!$ticket) {
        return redirect('/ticket')->withErrors(['email' => 'Ticket non trouvé']);
    }

    if (!$user->hasPermission('view_other_ticket') and (!$ticket || $ticket->user_id != $user->id)) {
        return redirect('/ticket')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    if (!$user->hasPermission('reply_ticket')) {
        return redirect('/ticket')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    if ($ticket->isClosed()) {
        return redirect('/ticket')->withErrors(['email' => 'Ce ticket est fermé. Vous ne pouvez pas y répondre.']);
    }

    Dialogue::create([
        "reponse" => $request->reponse,
        "user_id" => $user->id,
        "ticket_id" => $request->ticket_id,
        "user_name" => $user->name,
    ]);



    return redirect('/ticket_dialogue/' . $request->ticket_id)->with('reponse', 'Votre message a bien ete envoye. Vous pouvez maintenant le consulte  les commentaire du ticket.');
});
Route::get('/ticket_dialogue/{id}', function ($id) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login') - withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    if (!$user->hasPermission('view_tickets')) {
        return redirect('/')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $ticket = Ticket::find($id);
    if (!$ticket or ($ticket->user_id != $user->id and !$user->hasPermission('view_other_ticket'))) {
        return redirect('/ticket')->withErrors(['email' => 'Ticket non trouvé']);
    }

    $dialogues = Dialogue::where('ticket_id', $id)->get();
    $permissions = getPermission_navbar($user);
    return view('ticket_dialogue', compact("ticket", "dialogues", "permissions"));
});

Route::post('/ticket/{id}/statut', function (Request $request, $id) use ($statusTicket) {
    $user  = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    if (!$user->hasPermission('change_status_ticket')) {
        return redirect('/ticket')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }


    $request->validate([
        'statut' => 'required|in:' . implode(',', array_keys($statusTicket))
    ]);

    $ticket = Ticket::find($id);
    if (!$ticket) {
        return redirect('/ticket')->withErrors(['email' => 'Ticket non trouvé']);
    }

    $ticket->statut = $request->statut;
    $ticket->save();

    return redirect('/ticket')->with('statut_modifie', 'Statut modifié !');
});
Route::post('/ticket/{id}/supprimer', function (Request $request, $id) {
    $user  = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    if (!$user->hasPermission('delete_ticket')) {
        return redirect('/ticket')->withErrors(['email' => 'Accès refusé. Vous n avez pas la permission daccéder à cette page']);
    }

    $ticket = Ticket::find($id);
    if (!$ticket) {
        return redirect('/ticket')->withErrors(['email' => 'Ticket non trouvé']);
    }

    $ticket->delete();

    return redirect('/ticket')->with('ticket_supprimr', 'Ticket supprimé !');
});

// MODULE: Facture
function generatePDF($facture)
{
    $pdf = Pdf::loadView('facture_pdf', compact('facture'));
    $pdf->setPaper('A4', 'portrait');
    return $pdf->download($facture->reference . '.pdf');
}

$CONFIG_STATUS = [
    'pending' => 'En attente',
    'paid' => 'Payée',
    'cancelled' => 'Annulée',
];

Route::get("/factures", function () use ($CONFIG_STATUS) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    if (!$user->hasPermission('view_facture')) {
        return redirect('/')->with("error", [
            "title" => "Accès refusé",
            "message" => "Vous n'avez pas les permissions nécessaires pour accéder à cette page."
        ]);
    }

    $factures = Facture::all();
    $permissions = getPermission_navbar($user);
    return view('facture', compact('factures', 'CONFIG_STATUS', 'permissions'));
});

Route::post("/factures-add", function (Request $request) use ($CONFIG_STATUS) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    $request->validate([
        'client_name' => 'required|string|max:255',
        'products' => 'required|json',
        'status' => 'required|in:' . implode(',', array_keys($CONFIG_STATUS)),
        'due_date' => 'required|date',
    ]);

    $products = json_decode($request->products, true);
    $total_amount = 0;

    if ($products === null || !is_array($products)) {
        return back()->withErrors(['products' => 'Le format des produits est invalide']);
    }

    foreach ($products as $product) {
        $total_amount += $product['price'] * $product['quantity'];
    }

    if ($total_amount < 0) {
        return back()->withErrors(['products' => 'Le montant total ne peut pas être négatif']);
    }

    if (!isset($CONFIG_STATUS[$request->status])) {
        return back()->withErrors(['status' => 'Statut invalide']);
    }

    Facture::create([
        'reference' => 'FAC-' . Str::upper(Str::random(8)),
        'client_name' => $request->client_name,
        'products' => $request->products,
        'total_amount' => $total_amount,
        'status' => $request->status,
        'due_date' => $request->due_date,
    ]);

    return back()->with('success', 'Facture ajoutée avec succès');
});

Route::post("/factures/{id}", function (Request $request, $id) use ($CONFIG_STATUS) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    $facture = Facture::find($id);
    if (!$facture) {
        return back()->withErrors(['error' => 'Facture non trouvée']);
    }

    $request->validate([
        'client_name' => 'required|string|max:255',
        'products' => 'required|json',
        'status' => 'required|in:' . implode(',', array_keys($CONFIG_STATUS)),
        'due_date' => 'required|date',
    ]);

    $products = json_decode($request->products, true);
    $total_amount = 0;

    if ($products === null || !is_array($products)) {
        return back()->withErrors(['products' => 'Le format des produits est invalide']);
    }

    foreach ($products as $product) {
        $total_amount += $product['price'] * $product['quantity'];
    }

    if ($total_amount < 0) {
        return back()->withErrors(['products' => 'Le montant total ne peut pas être négatif']);
    }

    if (!isset($CONFIG_STATUS[$request->status])) {
        return back()->withErrors(['status' => 'Statut invalide']);
    }

    $facture->update([
        'client_name' => $request->client_name,
        'products' => $request->products,
        'total_amount' => $total_amount,
        'status' => $request->status,
        'due_date' => $request->due_date,
    ]);

    return back()->with('success', 'Facture modifiée avec succès');
});

Route::delete("/factures/{id}", function ($id) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    $facture = Facture::find($id);
    if (!$facture) {
        return back()->withErrors(['error' => 'Facture non trouvée']);
    }

    $facture->delete();
    return back()->with('success', 'Facture supprimée avec succès');
});

Route::get("/factures-download/{id}", function ($id) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    $facture = Facture::find($id);
    if (!$facture) {
        return back()->withErrors(['error' => 'Facture non trouvée']);
    }

    return generatePDF($facture);
});
