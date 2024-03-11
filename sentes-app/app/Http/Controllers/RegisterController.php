<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Attendee;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {
        // password must contain 1 number, 1 uppercase letter, 1 special character and be between 10 and 25 characters long :
        $passwordRegex = '/^(?=.*\d)(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{10,25}$/';

        $attributes = request()->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' =>  ['required', 'max:50'],
            'login' =>  ['required', 'min:3', 'max:50', Rule::unique('users', 'login')],
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')],
            'password' => ['required', 'min:10', 'max:25', 'confirmed', 'regex:' . $passwordRegex],
            'accepted_terms' => ['required'],
        ]);

        $attributes['avatar_path'] = 'users/avatars/blank-profile.png';


        $user = User::create($attributes);

        auth()->login($user);
        session()->flash('success', 'Ton compte a bien été créé ! Bienvenue, ' . auth()->user()->login . ' !');

        return redirect('/');
    }

    public function edit(User $user)
    {
        if (auth()->user()->id !== $user->id) {
            abort(403, 'Tu n\'as pas le droit de voir cette page');
        }
        return view('user.edit', compact('user'));
    }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' =>  ['required', 'max:50'],
            'login' =>  ['required', 'min:3', 'max:50', Rule::unique('users', 'login')->ignore($user->id)],
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user->id)],
            'city' =>  ['nullable', 'max:50'],
            'avatar_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if (request()->hasFile('avatar_path')) {
            $attributes['avatar_path'] = request('avatar_path')->store('public/users/avatars');
            $attributes['avatar_path'] = str_replace('public/', '', $attributes['avatar_path']);
        }

        $user->update($attributes);

        session()->flash('success', 'Ton proﬁl a bien été mis à jour !');

        return redirect(route('profile.myProfile', $user));
    }

    public function show(User $user)
    {
        return view('user.public.profile', compact('user'));
    }

    public function myProfile()
    {
        return view('user.profile', ['user' => auth()->user()]);
    }

    public function destroy(User $user)
    {
        if (auth()->user()->id !== $user->id) {
            abort(403, 'Tu n\'as pas le droit de voir cette page');
        }
        $user->delete();

        session()->flash('success', 'Ton compte a bien été supprimé !');

        return redirect('/');
    }
}
