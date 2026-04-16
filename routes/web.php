<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }

    $users = User::all()->count();
    $lastUser = User::latest()->first();
    // TODO: Récupérer les données d'activité depuis le paramètre
    // TODO: Récupérer le nombre de ticket à traiter et traité depuis tickets

    return view('welcome', compact('users', 'lastUser'));
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

// TODO: Add HasPermissions
$CONFIG_STATUS_ITEMS = [
    "En stock",
    "Bientôt épuisé",
    "Rupture de stock"
];

Route::get("/storage", function () use ($CONFIG_STATUS_ITEMS) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour accéder à cette page']);
    }

    $inventoryItems = Inventory::all();
    return view("storage", compact("inventoryItems", "CONFIG_STATUS_ITEMS"));
});

Route::post("/inventory-add", function (Request $request) use ($CONFIG_STATUS_ITEMS) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour ajouter un item']);
    }

    $request->validate([
        'product_name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
    ]);

    if (!in_array($request->status, $CONFIG_STATUS_ITEMS)) {
        return back()->withErrors(['status' => 'Status invalide']);
    }

    Inventory::create([
        'product_name' => $request->product_name,
        'quantity' => $request->quantity,
        'status' => $request->status,
    ]);

    return back()->with('success', 'Item ajouté avec succès');
});

Route::delete("/inventory/{id}", function ($id) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour supprimer un item']);
    }

    $item = Inventory::find($id);
    if (!$item) {
        return back()->withErrors(['error' => 'Item non trouvé']);
    }

    $item->delete();
    return back()->with('success', 'Item supprimé avec succès');
});

Route::post("/inventory/{id}", function (Request $request, $id) use ($CONFIG_STATUS_ITEMS) {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Vous devez être connecté pour modifier un item']);
    }

    $item = Inventory::find($id);
    if (!$item) {
        return back()->withErrors(['error' => 'Item non trouvé']);
    }

    $request->validate([
        'product_name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
    ]);

    if (!in_array($request->status, $CONFIG_STATUS_ITEMS)) {
        return back()->withErrors(['status' => 'Status invalide']);
    }

    $item->update([
        'product_name' => $request->product_name,
        'quantity' => $request->quantity,
        'status' => $request->status,
    ]);

    return back()->with('success', 'Item modifié avec succès');
});
