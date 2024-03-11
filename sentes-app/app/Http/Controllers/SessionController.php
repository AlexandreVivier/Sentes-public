<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('session.create');
    }

    public function store()
    {
        $credentials = request()->only('email', 'password');
        $remember = request()->filled('remember');

        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials, $remember)) {
            session()->regenerate();
            return redirect('/')->with('success', 'Bienvenue à toi, ' . auth()->user()->login . ' !');
        }

        throw ValidationException::withMessages([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Tu es déconnecté·e. À bientôt !');
    }
}
