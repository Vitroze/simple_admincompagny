<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rank;
use Illuminate\Support\Facades\Auth;
use App\Models\Facture;

// Generate PDF
use Barryvdh\DomPDF\Facade\Pdf;

function generatePDF($facture)
{
    $pdf = Pdf::loadView('facture_pdf', compact('facture'));
    $pdf->setPaper('A4', 'portrait');
    return $pdf->download($facture->reference . '.pdf');
}

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

Route::get('/manage-users', function () {

    $hasUser = Auth::user();
    if (!$hasUser) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    $user = Auth::user();
    if (!$user->hasPermission('manage_users')) {
        return redirect('/')->with("error", [
            "title" => "Accès refusé",
            "message" => "Vous n'avez pas les permissions nécessaires pour accéder à cette page."
        ]);
    }

    $users = User::all();
    $ranks = Rank::all();
    $hasPermissionDelete = $user->hasPermission('delete_users');
    $hasPermissionEdit = $user->hasPermission('edit_users');
    $hasPermissionSetRank = $user->hasPermission('setrank');
    $permissions = getPermission_navbar($user);
    return view('manage_users', compact('users', 'ranks', 'hasPermissionDelete', 'hasPermissionEdit', 'hasPermissionSetRank', 'permissions'));
});

//bouton supprimmer
Route::delete('/users/{id}', function ($id) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['nologin' => 'Vous devez être connecté pour accéder à cette page']);
    }

    $userDelete = User::findOrFail($id);
    if ($userDelete->id === $user->id) {
        return redirect('/manage-users')->withErrors(['error' => 'Vous ne pouvez pas supprimer votre propre compte']);
    }

    if (!$user->hasPermission('manage_users') or !$user->hasPermission('delete_users', $userDelete)) {
        return back()->withErrors(['error' => 'Vous n\'avez pas les permissions nécessaires pour supprimer cette utilisateur']);
    }

    $userDelete->delete();

    return back()->with('success', 'Utilisateur supprimé avec succès');
});
//
Route::post('/users/{id}', function (Request $request, $id) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    $userEdit = User::findOrFail($id);
    if (!$userEdit) {
        return back()->withErrors(['error' => 'Utilisateur non trouvé']);
    }

    if (!$user->hasPermission('manage_users') or !$user->hasPermission('edit_users', $userEdit)) {
        return back()->withErrors(['error' => 'Vous n\'avez pas les permissions nécessaires pour modifier cette utilisateur']);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'usergroup' => 'string|exists:ranks,name',
    ]);

    if ($request->usergroup and $request->usergroup != $userEdit->usergroup and !$user->hasPermission('setrank', $userEdit)) {
        return back()->withErrors(['error' => 'Vous n\'avez pas les permissions nécessaires pour changer le rang d\'un utilisateur']);
    }

    if ($user->id == $id) {
        return back()->withErrors(['error' => 'Vous ne pouvez pas modifier votre propre compte']);
    }

    $userEdit->usergroup = $request->usergroup;
    $userEdit->name = $request->name;
    $userEdit->save();

    return back()->with('success', 'Utilisateur modifié avec succès');
});

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
