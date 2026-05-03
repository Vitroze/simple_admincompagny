<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rank;
use App\Models\Inventory;
use App\Models\Role;
use App\Models\Droit;
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

Route::get('/settings', function () {
    $user = Auth::user();
    if (!$user) return redirect('/login');

    $roles = Role::all();
    $users = User::all();
    return view('settings', compact('roles', 'users', 'user'));
});

Route::post('/settings', function (Request $request) {
    $request->validate([
        "nom" => "required|string|max:255|unique:role,nom",
    ]);

    Role::create([
        "nom" => $request->nom,
    ]);

    return redirect('/settings')->with('roles', 'Le rôle a été créé avec succès.');
});

Route::post('/settings/droit',function(Request $request){  
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }

    Droit::updateOrCreate(
        ['user_id' => $request->user_id,
         'role_id' => $request->role_id
        ],
        [
            'ticket' => $request->input('ticket', 0),
            'inventaire' => $request->input('inventaire', 0),
            'gerer_user' => $request->input('gerer_user', 0),
            'gerer_facture' => $request->input('gerer_facture', 0),
            'parametre' => $request->input('parametre', 0),
        ]
    );
 
    return redirect('/settings')->with('permission', 'Les permissions ont été attribuées ou modifiées avec succès.');
});


Route::get('tickets', function () {
    $user = Auth::user();
    $droit = Droit::where('user_id', $user->id)->first();
    if (!$droit || !$droit->ticket) {
        return redirect('/')->with('error','Accès refusé. Vous n avez pas la permission daccéder à cette page');
    }

    return view('tickets');
});
Route::get('inventaire', function () {
    $user = Auth::user();
    $droit = Droit::where('user_id', $user->id)->first();
    if (!$droit || !$droit->inventaire) {
        return redirect('/')->with('error','Accès refusé. Vous n avez pas la permission daccéder à cette page');
    }

    return view('inventaire');
});
Route::get('gerer_user', function () {
    $user = Auth::user();
    $droit = Droit::where('user_id', $user->id)->first();
    if (!$droit || !$droit->gerer_user) {
        return redirect('/')->with('error','Accès refusé. Vous n avez pas la permission daccéder à cette page');
    }

    return view('gerer_user');
});
Route::get('gerer_facture', function () {
    $user = Auth::user();
    $droit = Droit::where('user_id', $user->id)->first();
    if (!$droit || !$droit->gerer_facture) {
        return redirect('/')->with('error','Accès refusé. Vous n avez pas la permission daccéder à cette page');
    }
    return view('gerer_facture');
});
Route::get('parametre', function () {
    $user = Auth::user();
    $droit = Droit::where('user_id', $user->id)->first ();
    if (!$droit || !$droit->parametre) {
        return redirect('/')->with('error','Accès refusé. Vous n avez pas la permission daccéder à cette page');
    }
    return view('parametre');
});
Route::post('settings/supprimer',function(Request $request){
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }
    $utilisateur = User::where('id', $request->user_id)->first();
    
    Droit::where('user_id',$request->user_id)
            ->where('role_id',$request->role_id)
            ->delete();


    return redirect('/settings')->with('droit', 'Les droits ont été supprimés avec succès.');
});