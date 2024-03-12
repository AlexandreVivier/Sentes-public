<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Location;
use App\Models\Attendee;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['organizers.user', 'attendees.user'])
            ->where('start_date', '>', now())
            ->where('is_cancelled', false)
            ->filter(request(['search']))
            ->orderBy('start_date')
            ->paginate(4);

        $locations = cache()->rememberForever('locations', function () {
            return Location::all()
                ->sortByDesc('zip_code');
        });
        return view('events.index', compact('events', 'locations'));
    }


    public function create()
    {
        return view('events.create', ['locations' => Location::all()]);
    }

    public function store()
    {
        $authorId = auth()->id();

        $attributes = request()->validate([
            'title' => ['required', 'max:99', Rule::unique('events', 'title')],
            'description' => ['required', 'max:99'],
            'start_date' => ['required', 'date', 'after:now'],
            'location_id' => ['required', Rule::exists('locations', 'id')],
        ]);

        cache()->forget('events');

        $event = Event::create($attributes);
        Attendee::create([
            'event_id' => $event->id,
            'user_id' => auth()->user()->id,
            'is_organizer' => true,
        ]);

        return redirect(route('events.edit', $event));
    }

    public function edit(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le modifier !');
        }

        return view('events.createStep2', compact('event'));
    }

    public function update(Event $event)
    {

        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le modifier !');
        }

        $attributes = request()->validate([
            'title' => ['max:99'],
            'description' => ['max:99'],
            'start_date' => ['date', 'after:now'],
            'location_id' => [Rule::exists('locations', 'id')],
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
            $attributes['image_path'] = 'events/images/blank-event.png';
        }

        if (request()->hasFile('file_path')) {
            $attributes['file_path'] = request('file_path')->store('public/events/files');
            $attributes['file_path'] = str_replace('public/', '', $attributes['file_path']);
        }

        $userId = auth()->user()->id;

        cache()->forget('events');
        cache()->forget("event-{$event->id}", $event->id);
        cache()->forget("my-events-{$userId}", auth()->user()->id);
        $event->update($attributes);

        session()->flash('success', 'Ton évènement a bien été créé !');
        return redirect(route('events.show', $event));
    }

    public function show(Event $event)
    {
        $event = cache()->rememberForever("event-{$event->id}", function () use ($event) {
            return $event;
        });
        $attendees = $event->attendees()->get();
        $organizers = $event->organizers()->get();
        $location = $event->location()->first();

        return view('events.show', compact('event', 'attendees', 'organizers', 'location'));
    }

    public function destroy(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le supprimer !');
        }

        cache()->forget('events');
        cache()->forget("event-{$event->id}", $event->id);
        $event->delete();

        return redirect(route('events.index'));
    }

    public function cancel(Event $event)
    {

        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour l\'annuler !');
        }

        $userId = auth()->user()->id;

        cache()->forget('events');
        cache()->forget("event-{$event->id}", $event->id);
        cache()->forget("my-events-{$userId}", auth()->user()->id);
        $event->cancel();

        session()->flash('success', 'Ton évènement a bien été annulé !');
        return redirect(route('events.index'));
    }

    public function getEventOrganizers($eventId)
    {
        $event = Event::find($eventId);
        $organizers = $event->attendees()->organizers()->get();
        if ($organizers) {
            return true;
        } else {
            return false;
        }
    }

    public function GetAllEventOrganizersLogins($eventId)
    {
        $event = Event::find($eventId);
        $organizers = $event->organizers()->get();
        $organizersLogins = [];
        foreach ($organizers as $organizer) {
            $organizersLogins[] = $organizer->user->login;
        }
        return $organizersLogins;
    }

    public function checkIfUserIsOrganizer($eventId)
    {
        $event = Event::find($eventId);
        $isOrganizer = $event->attendees()->where('user_id', auth()->id())->where('is_organizer', true)->exists();
        if ($isOrganizer) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllEventsOrganizedByUser($userId)
    {
        $events = cache()->rememberForever("my-events-{$userId}", function () use ($userId) {
            return Event::with(['organizers.user', 'attendees.user'])
                ->whereHas('organizers', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->orderBy('start_date')
                ->get();
        });

        return view('user.organisations.index', compact('events'));
    }

    public function getPastsEvents()
    {
        $pastsEvents = Event::latest()
            ->with(['organizers.user', 'attendees.user'])
            ->where('start_date', '<', now())
            ->filter(request(['search']))
            ->orderBy('start_date')
            ->paginate(4);

        $locations = cache()->rememberForever('locations', function () {
            return Location::all()
                ->sortByDesc('zip_code');
        });
        return view('events.pasts', compact('pastsEvents', 'locations'));
    }
}
