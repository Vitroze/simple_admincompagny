<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }

    return view('welcome');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/')->withErrors(['email' => 'Vous êtes déjà connecté']);
    }

    return view('login');
});

Route::post('/login', function (Request $request) {
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
    return view('register');
});

Route::post('/register', function (Request $request) {
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
    Auth::logout();
    return redirect('/login');
});

Route::get('/manage-users', function () {

    $hasUser = Auth::user();
    if (!$hasUser) {
        return redirect('/login')->withErrors(['nologin' => 'Vous devez être connecté pour accéder à cette page']);
    }

    $user = Auth::user();
    if (!$user->hasPermission('manage_users')) {
        return redirect('/')->with("error", [
            "title" => "Accès refusé",
            "message" => "Vous n'avez pas les permissions nécessaires pour accéder à cette page."
        ]);
    }

    $users = User::all();
    return view('manage_users', ['users' => $users]);
})->middleware('auth');


Route::delete('/users/{id}', function ($id) {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect('/manage-users')->with('success', 'Utilisateur supprimé');
})->middleware('auth');
