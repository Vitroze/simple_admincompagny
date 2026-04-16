<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
//use PHPUnit\Framework\Attributes\Ticket;
use App\Models\Ticket;


Route::get('/', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }

    return view('welcome');
});

Route::get('/login', function () {
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


Route::get('/ticket', function () {
    return view('ticket');
});

Route::get('/ticket',function(Request $request){

    $request->validate([
            "description"=>"required",
            "statu"=>"required",
            "date_tiket"=>"required",
        ]);
    
    Ticket::create([
        "description"=>$request->description,
        "statu"=>$request->statu,
        "date_tiket"=>$request->date_tiket,
        ]);

    // return redirect('/ticket')->with('success', 'Votre ticket a été créé avec succès. Vous pouvez maintenant le consulte sur voir mes tickes.');
});



//retire le contoler est le metre dans web.php avec ci qu il y a dans la class tiketContoler et rajouter dans web.php le lien avec le model tike.php
