<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Event;
use App\Models\User;
use App\Models\Attendee;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventUpdated;
use App\Notifications\NewEvent;

class AdminController extends Controller
{
    public function index()
    {

        return view('admin.index');
    }

    // ****************** USERS ****************** //

    public function userIndex()
    {
        $users = User::all();
        $titles = ['Avatar', 'Pseudo', 'Prénom', 'Nom', 'Email', 'Inscription'];

        $users =  User::with('attendees')->orderBy('id')->get();

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

        if (request()->hasFile('avatar_path')) {
            $attributes['avatar_path'] = request('avatar_path')->store('public/users/avatars');
            $attributes['avatar_path'] = str_replace('public/', '', $attributes['avatar_path']);
        } else {
            $attributes['avatar_path'] = 'images/static/blank-profile.png';
        }

        cache()->forget('users');
        $user = User::create($attributes);

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
        session()->flash('success', 'Le compte a bien été modifié !');

        return view('admin.show', compact('user'));
    }

    public function userDestroy(User $user)
    {
        $attendees = $user->attendees()->get();

        foreach ($attendees as $attendee) {
            $event = $attendee->event;
            $event->attendee_count -= 1;
            $event->save();
            cache()->forget("event-{$event->id}", $event->id);
        }

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

        foreach ($attendees as $attendee) {
            $attendee->delete();
        }
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
            return Location::all()->sortBy('id');
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


        $locationEvents = $location->events()->get();

        foreach ($locationEvents as $event) {
            cache()->forget("event-{$event->id}", $event->id);
        }

        foreach ($locationEvents as $event) {
            $attendees = $event->attendees()->get();
            foreach ($attendees as $attendee) {
                cache()->forget("my-events-{$attendee->user_id}", $attendee->user_id);
                cache()->forget("my-subscribed-events-{$attendee->user_id}", $attendee->user_id);
            }
        }
        cache()->forget('events');
        cache()->forget('locations');
        $location->update($attributes);
        session()->flash('success', 'Le lieu a bien été modifié !');

        return view('admin.show', compact('location'));
    }

    public function locationDestroy(Location $location)
    {

        $locationEvents = $location->events()->get();

        foreach ($locationEvents as $event) {
            cache()->forget("event-{$event->id}", $event->id);
        }

        foreach ($locationEvents as $event) {
            $attendees = $event->attendees()->get();
            foreach ($attendees as $attendee) {
                cache()->forget("my-events-{$attendee->user_id}", $attendee->user_id);
                cache()->forget("my-subscribed-events-{$attendee->user_id}", $attendee->user_id);
            }
        }
        cache()->forget('events');
        cache()->forget('locations');
        $location->delete();
        session()->flash('success', 'Le lieu a bien été supprimé !');

        return redirect(route('admin.locations.index'));
    }

    public function locationShow(Location $location)
    {
        return view('admin.show', compact('location'));
    }

    // ****************** EVENTS ****************** //
    public function eventIndex()
    {
        $events = Event::with(['organizers.user'])->orderBy('id')->get();
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
            'price' => ['nullable', 'numeric', 'min:1'],
            'max_attendees' => ['nullable', 'numeric', 'min:1'],
            'image_path' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'file_path' => ['nullable', 'file', 'max:2048', 'mimes:pdf'],
            'server_link' => ['nullable', 'url', 'starts_with:https://discord.gg/'],
            'tickets_link' => ['nullable', 'url', 'starts_with:https://'],
        ]);

        if (request()->hasFile('image_path')) {
            $attributes['image_path'] = request('image_path')->store('public/events/images');
            $attributes['image_path'] = str_replace('public/', '', $attributes['image_path']);
        } else {
            $attributes['image_path'] = 'images/static/blank-event.png';
        }

        if (request()->hasFile('file_path')) {
            $attributes['file_path'] = request('file_path')->store('public/events/files');
            $attributes['file_path'] = str_replace('public/', '', $attributes['file_path']);
        }

        cache()->forget('events');
        $event = Event::create($attributes);
        Attendee::create([
            'event_id' => $event->id,
            'user_id' => auth()->user()->id,
            'is_organizer' => true,
        ]);
        $event->attendee_count += 1;
        $event->save();

        $author = auth()->user();

        $users = User::all();
        Notification::send($users, new NewEvent($event, $author));

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
            'price' => ['nullable', 'numeric', 'min:1'],
            'max_attendees' => ['nullable', 'numeric', 'min:1'],
            'image_path' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
            'end_date' => ['nullable', 'date'],
            'file_path' => ['nullable', 'file', 'max:2048', 'mimes:pdf'],
            'server_link' => ['nullable', 'url', 'starts_with:https://discord.gg/'],
            'tickets_link' => ['nullable', 'url', 'starts_with:https://'],
            'photos_link' => ['nullable', 'url', 'starts_with:https://'],
            'video_link' => ['nullable', 'url', 'starts_with:https://'],
            'retex_form_link' => ['nullable', 'url', 'starts_with:https://'],
            'retex_document_path' => ['nullable', 'file', 'max:2048', 'mimes:pdf'],
        ]);

        if (request('is_cancelled')) {
            $event->cancel();
        } else {
            $event->uncancel();
        }

        if (request()->hasFile('image_path')) {
            $attributes['image_path'] = request('image_path')->store('public/events/images');
            $attributes['image_path'] = str_replace('public/', '', $attributes['image_path']);
        }

        if (request()->hasFile('file_path')) {
            $attributes['file_path'] = request('file_path')->store('public/events/files');
            $attributes['file_path'] = str_replace('public/', '', $attributes['file_path']);
        }

        if (request()->hasFile('retex_document_path')) {
            $attributes['retex_document_path'] = request('retex_document_path')->store('public/events/files');
            $attributes['retex_document_path'] = str_replace('public/', '', $attributes['retex_document_path']);
        }

        $organizers = $event->organizers()->get();

        cache()->forget('events');
        cache()->forget("event-{$event->id}", $event->id);
        foreach ($organizers as $organizer) {
            cache()->forget("my-events-{$organizer->user_id}", $organizer->user_id);
            cache()->forget("my-subscribed-events-{$organizer->user_id}", $organizer->user_id);
        }
        $event->update($attributes);

        $attendees = $event->attendees()->where('is_subscribed', true)->get();
        $attendees = User::whereIn('id', $attendees->pluck('user_id'))->get();
        Notification::send($attendees, new EventUpdated($event));


        session()->flash('success', 'L\'évènement a bien été modifié !');

        return view('admin.show', compact('event'));
    }

    public function eventDestroy(Event $event)
    {

        $organizers = $event->organizers()->get();

        cache()->forget('events');
        cache()->forget("event-{$event->id}", $event->id);
        foreach ($organizers as $organizer) {
            cache()->forget("my-events-{$organizer->user_id}", $organizer->user_id);
            cache()->forget("my-subscribed-events-{$organizer->user_id}", $organizer->user_id);
        }
        $attendees = $event->attendees()->get();
        foreach ($attendees as $attendee) {
            $attendee->delete();
        }
        $event->delete();


        session()->flash('success', 'L\'évènement a bien été supprimé !');

        return redirect(route('admin.events.index'));
    }

    public function eventShow(Event $event)
    {
        $event = cache()->rememberForever("event-{$event->id}", function () use ($event) {
            return Event::with('attendees', 'organizers')->find($event->id);
        });
        return view('admin.show', compact('event'));
    }
}
