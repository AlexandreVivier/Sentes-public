<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Attendee;
use Illuminate\Auth\Events\Registered;

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
        event(new Registered($user));
        auth()->login($user);
        session()->flash('success', 'Ton compte a bien été créé ! Vérifie ta boîte mail pour activer ton compte !');

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
            'biography' => ['nullable', 'max:500'],
            'pronouns' => ['nullable', 'max:10'],
            'first_aid_qualifications' => ['nullable', 'max:100'],
            'allergies' => ['nullable', 'max:100'],
            'medical_conditions' => ['nullable', 'max:100'],
            'diet_restrictions' => ['nullable', 'max:100'],
            'red_flag_people' => ['nullable', 'max:100'],
            'emergency_contact_name' => ['nullable', 'max:100'],
            'emergency_contact_phone_number' => ['nullable', 'max:20'],
            'discord_username' => ['nullable', 'max:50'],
            'facebook_username' => ['nullable', 'max:50'],
            'trigger_warnings' => ['nullable', 'max:100'],
            'phone_number' => ['nullable', 'max:20'],
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
                cache()->forget("my-subscribed-events-{$organizer->user_id}", $organizer->user_id);
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

        cache()->forget("my-events-{$user->id}", $user->id);
        cache()->forget("my-subscribed-events-{$user->id}", $user->id);
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
                cache()->forget("my-subscribed-events-{$organizer->user_id}", $organizer->user_id);
            }
        }
        $attendees = $user->attendees()->get();
        foreach ($attendees as $attendee) {
            $attendee->delete();
        }
        $user->delete();

        session()->flash('success', 'Ton compte a bien été supprimé !');

        return redirect('/');
    }
}
