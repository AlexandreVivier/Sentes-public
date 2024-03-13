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

        $attributes['avatar_path'] = 'images/static/blank-profile.png';



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


        cache()->forget('users');
        cache()->forget("user-{$user->id}", $user->id);
        $organizedEvents = $user->allEvents()->get();

        cache()->forget('events');

        foreach ($organizedEvents as $event) {
            cache()->forget("event-{$event->id}", $event->id);
        }
        foreach ($organizedEvents as $event) {
            $organizers = $event->organizers()->get();
            foreach ($organizers as $organizer) {
                cache()->forget("my-events-{$organizer->user_id}", $organizer->user_id);
            }
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

        cache()->forget('users');
        cache()->forget("user-{$user->id}", $user->id);
        cache()->forget("my-events-{$user->id}", $user->id);
        cache()->forget('events');
        $attendees = Attendee::where('user_id', $user->id)->get();
        foreach ($attendees as $attendee) {
            $attendee->delete();
        }


        cache()->forget('users');
        cache()->forget("user-{$user->id}", $user->id);
        $organizedEvents = $user->allEvents()->get();

        cache()->forget('events');

        foreach ($organizedEvents as $event) {
            cache()->forget("event-{$event->id}", $event->id);
        }
        foreach ($organizedEvents as $event) {
            $organizers = $event->organizers()->get();
            foreach ($organizers as $organizer) {
                cache()->forget("my-events-{$organizer->user_id}", $organizer->user_id);
            }
        }
        $user->delete();

        session()->flash('success', 'Ton compte a bien été supprimé !');

        return redirect('/');
    }
}
