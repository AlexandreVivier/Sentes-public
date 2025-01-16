<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Location;
use App\Models\Attendee;
use App\Models\ArchetypeCategory;
use App\Models\ArchetypeList;
use App\Models\Archetype;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewEvent;
use App\Notifications\EventUpdated;
use App\Notifications\EventCancelled;

// temp
use App\Jobs\TestJob;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with([
            'organizers.user:id,login',
            'attendees.user:id,login',
        ])
            ->where('start_date', '>', now())
            ->where('is_cancelled', false)
            ->whereHas('profile', function ($query) {
                $query->where('published', 1);
            })
            ->filter(request(['search']))
            ->orderBy('start_date')
            ->paginate(4)->withQueryString();

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
        session()->flash('success', 'Ton évènement a bien été créé !');
        Profile::create([
            'event_id' => $event->id,
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

        $organizers = $event->organizers()->get();

        cache()->forget('events');
        cache()->forget("event-{$event->id}", $event->id);
        foreach ($organizers as $organizer) {
            cache()->forget("my-events-{$organizer->user_id}", $organizer->user_id);
            cache()->forget("my-subscribed-events-{$organizer->user_id}", $organizer->user_id);
        }
        $event->update($attributes);

        session()->flash('success', 'Ton évènement a bien été mis à jour !');
        return redirect(route('events.show', $event));
    }

    public function show(Event $event)
    {
        $event = cache()->rememberForever("event-{$event->id}", function () use ($event) {
            return $event;
        });

        return view('events.show', compact('event'));
    }

    public function destroy(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le supprimer !');
        }

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

        return redirect(route('events.index'));
    }

    public function cancel(Event $event)
    {

        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour l\'annuler !');
        }
        $organizers = $event->organizers()->get();

        cache()->forget('events');
        cache()->forget("event-{$event->id}", $event->id);
        foreach ($organizers as $organizer) {
            cache()->forget("my-events-{$organizer->user_id}", $organizer->user_id);
            cache()->forget("my-subscribed-events-{$organizer->user_id}", $organizer->user_id);
        }
        $event->cancel();

        $attendees = $event->attendees()->where('is_subscribed', true)->get();
        $attendees = User::whereIn('id', $attendees->pluck('user_id'))->get();
        Notification::send($attendees, new EventCancelled($event));

        session()->flash('success', 'Ton évènement a bien été annulé !');
        return redirect(route('events.index'));
    }

    public function getAllFutureEventsOrganizedByUser($userId)
    {
        $events = cache()->rememberForever("my-events-{$userId}", function () use ($userId) {
            return Event::with(['organizers.user', 'attendees.user'])
                ->whereHas('organizers', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->where('start_date', '>', now())
                ->where('is_cancelled', false)
                ->orderBy('start_date')
                ->get();
        });

        return view('user.organisations.index', compact('events', 'userId'));
    }

    public function getAllPastEventsOrganizedByUser($userId)
    {
        $events = Event::with(['organizers.user', 'attendees.user'])
            ->whereHas('organizers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('start_date', '<', now())
            ->where('is_cancelled', false)
            ->orderBy('start_date')
            ->paginate(4)->withQueryString();

        $pastsEvents = true;

        return view('user.organisations.index', compact('events', 'pastsEvents', 'userId'));
    }

    public function getAllCancelledEventsOrganizedByUser($userId)
    {
        $events = Event::with(['organizers.user', 'attendees.user'])
            ->whereHas('organizers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('is_cancelled', true)
            ->orderBy('start_date')
            ->paginate(4)->withQueryString();

        $cancelledEvents = true;

        return view('user.organisations.index', compact('events', 'cancelledEvents', 'userId'));
    }

    public function getAllFutureEventsSubscribedByUser($userId)
    {
        $events = cache()->rememberForever("my-subscribed-events-{$userId}", function () use ($userId) {
            return Event::with(['organizers.user', 'attendees.user'])
                ->whereHas('attendees', function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->where('is_subscribed', true);
                })
                ->where('start_date', '>', now())
                ->where('is_cancelled', false)
                ->orderBy('start_date')
                ->get();
        });

        return view('user.events.index', compact('events', 'userId'));
    }

    public function getAllPastEventsSubscribedByUser($userId)
    {
        $events = Event::with(['organizers.user', 'attendees.user'])
            ->whereHas('attendees', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('is_subscribed', true);
            })
            ->where('start_date', '<', now())
            ->where('is_cancelled', false)
            ->orderBy('start_date')
            ->paginate(4)->withQueryString();

        $pastsEvents = true;

        return view('user.events.index', compact('events', 'pastsEvents', 'userId'));
    }

    public function getAllCancelledEventsSubscribedByUser($userId)
    {
        $events = Event::with(['organizers.user', 'attendees.user'])
            ->whereHas('attendees', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('is_subscribed', true);
            })
            ->where('is_cancelled', true)
            ->orderBy('start_date')
            ->paginate(4)->withQueryString();

        $cancelledEvents = true;

        return view('user.events.index', compact('events', 'cancelledEvents', 'userId'));
    }

    public function getPastsEvents()
    {
        $pastsEvents = Event::latest()
            ->with(['organizers.user', 'attendees.user'])
            ->where('start_date', '<', now())
            ->filter(request(['search']))
            ->orderBy('start_date')
            ->paginate(4)->withQueryString();

        $locations = cache()->rememberForever('locations', function () {
            return Location::all()
                ->sortByDesc('zip_code');
        });
        return view('events.pasts', compact('pastsEvents', 'locations'));
    }

    public function change(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le modifier !');
        }

        return view('events.edit', compact('event'), ['locations' => Location::all()]);
    }

    public function modify(Event $event)
    {

        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le modifier !');
        }

        $attributes = request()->validate([
            'title' => ['required', 'max:99', Rule::unique('events', 'title')->ignore($event->id)],
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
        if (request('is_cancelled')) {

            $attendees = $event->attendees()->where('is_subscribed', true)->get();
            $attendees = User::whereIn('id', $attendees->pluck('user_id'))->get();
            Notification::send($attendees, new EventCancelled($event));
            $event->cancel();
        } else {
            $event->uncancel();
        }

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


        session()->flash('success', 'Ton évènement a bien été mis à jour !');
        return redirect(route('events.show', $event));
    }

    public function postDateInfosUpdate(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le modifier !');
        }

        $attributes = request()->validate([
            'photos_link' => ['nullable', 'url', 'starts_with:https://'],
            'video_link' => ['nullable', 'url', 'starts_with:https://'],
            'retex_form_link' => ['nullable', 'url', 'starts_with:https://'],
            'retex_document_path' => ['nullable', 'file', 'max:2048', 'mimes:pdf'],
        ]);

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
        if (request()->hasFile('retex_document_path')) {
            $event->update(['retex_document_path' => $attributes['retex_document_path']]);
        }
        if (request()->has('retex_form_link')) {
            $event->update(['retex_form_link' => $attributes['retex_form_link']]);
        }
        if (request()->has('video_link')) {
            $event->update(['video_link' => $attributes['video_link']]);
        }
        if (request()->has('photos_link')) {
            $event->update(['photos_link' => $attributes['photos_link']]);
        }

        session()->flash('success', 'Ton évènement a bien été mis à jour !');
        return redirect(route('events.show', $event));
    }
}
