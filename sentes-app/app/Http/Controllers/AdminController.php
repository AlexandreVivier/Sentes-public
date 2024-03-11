<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Event;
use App\Models\User;
use App\Models\Attendee;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {

        return view('admin.index');
    }

    // ****************** USERS ****************** //

    public function userIndex()
    {
        $users = User::orderBy('id')->get();
        $titles = ['Avatar', 'Pseudo', 'Prénom', 'Nom', 'Email', 'Inscription'];

        $users = cache()->rememberForever('users', function () {
            return User::with('attendees')->orderBy('id')->get();
        });

        return view('admin.index', compact('users', 'titles'));
    }

    public function userCreate()
    {
        return view('admin.users.create');
    }

    public function userStore()
    {
        // password must contain 1 number, 1 uppercase letter, 1 special character and be between 10 and 25 characters long :
        $passwordRegex = '/^(?=.*\d)(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{10,25}$/';

        $attributes = request()->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' =>  ['required', 'max:50'],
            'login' =>  ['required', 'min:3', 'max:50', Rule::unique('users', 'login')],
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')],
            'password' => ['required', 'min:10', 'max:25', 'confirmed', 'regex:' . $passwordRegex],
            'is_admin' => ['boolean'],
            'avatar_path' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
            'city' => ['nullable', 'max:50'],
        ]);

        if (request('avatar_path')) {
            $attributes['avatar_path'] = request('avatar_path')->store('public/users/avatars');
            $attributes['avatar_path'] = str_replace('public/', '', $attributes['avatar_path']);
        }


        cache()->forget('users');
        $user = User::create($attributes);
        cache()->rememberForever('users', function () {
            return User::orderBy('id')->get();
        });
        session()->flash('success', 'Le compte a bien été créé !');

        return redirect(route('admin.users.show', $user));
    }

    public function userEdit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    public function userUpdate(User $user)
    {
        $attributes = request()->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' =>  ['required', 'max:50'],
            'login' =>  ['required', 'min:3', 'max:50', Rule::unique('users', 'login')->ignore($user->id)],
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user->id)],
            'is_admin' => ['boolean'],
            'is_banned' => ['boolean'],
            'avatar_path' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
            'city' => ['nullable', 'max:50'],
        ]);

        if (request()->hasFile('avatar_path')) {
            $attributes['avatar_path'] = request('avatar_path')->store('public/users/avatars');
            $attributes['avatar_path'] = str_replace('public/', '', $attributes['avatar_path']);
        } else {
            $attributes['avatar_path'] = '/images/static/blank-profile.png';
        }

        cache()->forget('users');
        cache()->forget("user-{$user->id}", $user->id);
        $user->update($attributes);
        session()->flash('success', 'Le compte a bien été modifié !');

        return view('admin.show', compact('user'));
    }

    public function userDestroy(User $user)
    {
        cache()->forget('users');
        $user->delete();
        session()->flash('success', 'Le compte a bien été supprimé !');

        return redirect(route('admin.users.index'));
    }

    public function userShow(User $user)
    {
        $user = cache()->rememberForever("user-{$user->id}", function () use ($user) {
            return User::with('attendees')->find($user->id);
        });
        return view('admin.show', compact('user'));
    }

    // ****************** LOCATIONS ****************** //

    public function locationIndex()
    {
        $locations = cache()->rememberForever('locations', function () {
            return Location::orderBy('id')->get();
        });
        $titles = ['Nom', 'Numéro', 'Rue', 'Ville', 'Code Postal', 'Créé le'];

        return view('admin.index', compact('locations', 'titles'));
    }

    public function locationCreate()
    {
        return view('admin.locations.create');
    }

    public function locationStore()
    {
        $attributes = request()->validate([
            'title' => ['required', 'max:99'],
            'number' => ['required', 'numeric', 'min:1'],
            'street' => ['required', 'max:99'],
            'city_name' => ['required', 'max:99'],
            'zip_code' => ['required', 'max:5'],
            'bis' => 'nullable',
            'addon' => 'nullable',
        ]);

        cache()->forget('locations');
        $location = Location::create($attributes);


        session()->flash('success', 'Le lieu a bien été créé !');

        return redirect(route('admin.locations.show', $location->id));
    }

    public function locationEdit(Location $location)
    {
        return view('admin.edit', compact('location'));
    }

    public function locationUpdate(Location $location)
    {
        $attributes = request()->validate([
            'title' => ['required', 'max:99'],
            'number' => ['required', 'numeric', 'min:1'],
            'street' => ['required', 'max:99'],
            'city_name' => ['required', 'max:99'],
            'zip_code' => ['required', 'max:5'],
            'bis' => 'nullable',
            'addon' => 'nullable',
        ]);

        cache()->forget('locations');
        $location->update($attributes);
        session()->flash('success', 'Le lieu a bien été modifié !');

        return view('admin.locations.show', compact('location'));
    }

    public function locationDestroy(Location $location)
    {
        cache()->forget('locations');
        $location->delete();
        session()->flash('success', 'Le lieu a bien été supprimé !');

        return redirect(route('admin.index'));
    }

    public function locationShow(Location $location)
    {
        return view('admin.show', compact('location'));
    }

    // ****************** EVENTS ****************** //

    public function eventIndex()
    {
        $events = Event::with('location', 'attendees', 'organizers')->orderBy('id')->get();
        $titles = ['Titre', 'Entête', 'Date de début', 'Lieu', 'Orga(s)'];

        return view('admin.index', compact('events', 'titles'));
    }

    public function eventCreate()
    {
        return view('admin.events.create', ['locations' => Location::all()]);
    }

    public function eventStore()
    {
        $attributes = request()->validate([
            'title' => ['required', 'max:99', Rule::unique('events', 'title')],
            'description' => ['required', 'max:99'],
            'start_date' => ['required', 'date', 'after:now'],
            'location_id' => ['required', Rule::exists('locations', 'id')],
            'author_id' => ['required', Rule::exists('users', 'id')],
            'price' => ['nullable', 'numeric', 'min:1'],
            'max_attendees' => ['nullable', 'numeric', 'min:1'],
            'image_path' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'file_path' => ['nullable', 'file', 'max:2048', 'mimes:pdf'],
            'server_link' => ['nullable', 'url', 'starts_with:https://discord.gg/'],
            'tickets_link' => ['nullable', 'url', 'starts_with:https://'],
        ]);


        if (request('image_path')) {
            $attributes['image_path'] = request('image_path')->store('public/events/images');
            $attributes['image_path'] = str_replace('public/', '', $attributes['image_path']);
        }

        if (request('file_path')) {
            $attributes['file_path'] = request('file_path')->store('public/events/files');
            $attributes['file_path'] = str_replace('public/', '', $attributes['file_path']);
        }

        cache()->forget('events');
        $event = Event::create($attributes);
        Attendee::create([
            'event_id' => $event->id,
            'user_id' => $attributes['author_id'],
            'is_organizer' => true,
        ]);

        session()->flash('success', 'L\'évènement a bien été créé !');

        return redirect(route('admin.events.show', $event));
    }

    public function eventEdit(Event $event)
    {
        return view('admin.edit', compact('event'), ['locations' => Location::all()]);
    }

    public function eventUpdate(Event $event)
    {
        $attributes = request()->validate([
            'title' => ['required', 'max:99', Rule::unique('events', 'title')->ignore($event->id)],
            'description' => ['required', 'max:99'],
            'start_date' => ['required', 'date'],
            'location_id' => ['required', Rule::exists('locations', 'id')],
            'author_id' => ['required', Rule::exists('users', 'id')],
            'price' => ['nullable', 'numeric', 'min:1'],
            'max_attendees' => ['nullable', 'numeric', 'min:1'],
            'image_path' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
            'end_date' => ['nullable', 'date'],
            'file_path' => ['nullable', 'file', 'max:2048', 'mimes:pdf'],
            'server_link' => ['nullable', 'url', 'starts_with:https://discord.gg/'],
            'tickets_link' => ['nullable', 'url', 'starts_with:https://'],
        ]);

        if (request('is_cancelled')) {
            $event->cancel();
        } else {
            $event->uncancel();
        }

        if (request('image_path')) {
            $attributes['image_path'] = request('image_path')->store('public/events/images');
            $attributes['image_path'] = str_replace('public/', '', $attributes['image_path']);
        }

        if (request('file_path')) {
            $attributes['file_path'] = request('file_path')->store('public/events/files');
            $attributes['file_path'] = str_replace('public/', '', $attributes['file_path']);
        }

        cache()->forget('events');
        cache()->forget("event-{$event->id}", $event->id);
        // TODO    foreach($orga)     cache()->forget("my-events-{$orgaId}", $orga->id);
        $event->update($attributes);
        session()->flash('success', 'L\'évènement a bien été modifié !');

        return view('admin.show', compact('event'));
    }

    public function eventDestroy(Event $event)
    {
        cache()->forget('events');
        cache()->forget("event-{$event->id}", $event->id);
        $event->delete();

        session()->flash('success', 'L\'évènement a bien été supprimé !');

        return redirect(route('admin.index'));
    }

    public function eventShow(Event $event)
    {
        $event = cache()->rememberForever("event-{$event->id}", function () use ($event) {
            return Event::with('location', 'attendees', 'organizers')->find($event->id);
        });
        return view('admin.show', compact('event'));
    }
}
