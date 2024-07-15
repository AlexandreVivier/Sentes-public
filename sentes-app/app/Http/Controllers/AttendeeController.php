<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewEventSubscriber;
use App\Notifications\NewEventUnsubscribe;
use App\Notifications\OrgaPromotion;
use App\Notifications\OrgaDowngrade;

class AttendeeController extends Controller
{

    public function subscribeToEvent(Event $event)
    {
        // $eventAttendesCount = $event->attendees()->where('is_subscribed', true)->count();
        $eventAttendesCount = $event->attendee_count;

        if ($eventAttendesCount >= $event->max_attendees) {
            session()->flash('error', 'Désolé, cet événement est complet !');
            return redirect(route('events.show', $event));
        }

        $user = auth()->user();

        if ($event->attendees()->where('user_id', $user->id)->exists()) {
            $attendee = Attendee::where('event_id', $event->id)->where('user_id', $user->id)->first();
            $attendee->resubscribe();
            $event->attendee_count += 1;
            $event->save();

            cache()->forget("my-subscribed-events-{$user->id}", $user->id);
            cache()->forget("my-events-{$user->id}", $user->id);
            cache()->forget("my-organized-events-{$user->id}", $user->id);
            cache()->forget("event-{$event->id}", $event->id);

            $organizers = $event->organizers;
            $organizers = User::whereIn('id', $organizers->pluck('user_id'))->get();

            Notification::sendNow($organizers, new NewEventSubscriber($event, $user));


            session()->flash('success', 'Tu es bien réinscrit·e à cet événement !');
            return redirect(route('events.show', $event));
        } else {
            $event->attendees()->create([
                'user_id' => $user->id,
                'has_paid' => false,
                'is_organizer' => false,
                'is_subscribed' => true
            ]);
            $event->attendee_count += 1;
            $event->save();
        }

        cache()->forget("my-subscribed-events-{$user->id}", $user->id);
        cache()->forget("my-events-{$user->id}", $user->id);
        cache()->forget("my-organized-events-{$user->id}", $user->id);
        cache()->forget("event-{$event->id}", $event->id);

        $organizers = $event->organizers;
        $organizers = User::whereIn('id', $organizers->pluck('user_id'))->get();

        Notification::sendNow($organizers, new NewEventSubscriber($event, $user));

        session()->flash('success', 'Tu es bien inscrit·e à l\'événement !');
        return redirect(route('events.show', $event));
    }

    public function unsubscribeFromEvent(Event $event)
    {
        $user = auth()->user();
        $attendee = Attendee::where('event_id', $event->id)->where('user_id', $user->id)->first();
        $attendee->unsubscribe();
        $event->attendee_count -= 1;
        $event->save();

        cache()->forget("my-subscribed-events-{$user->id}", $user->id);
        cache()->forget("my-events-{$user->id}", $user->id);
        cache()->forget("my-organized-events-{$user->id}", $user->id);
        cache()->forget("event-{$event->id}", $event->id);

        $organizers = $event->organizers;
        $organizers = User::whereIn('id', $organizers->pluck('user_id'))->get();

        Notification::sendNow($organizers, new NewEventUnsubscribe($event, $user));

        session()->flash('success', 'Tu es bien désinscrit·e de l\'événement !');
        return redirect(route('events.show', $event));
    }

    public function show(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le modifier !');
        }
        $organizers = $event->organizers;
        $attendees = $event->attendees;
        return view('events.attendees.show', compact('event', 'attendees'));
    }

    public function promoteOrganizer(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le modifier !');
        }

        $user = User::find(request('user_id'));
        $attendee = Attendee::where('event_id', $event->id)->where('user_id', $user->id)->first();
        $attendee->promoteOrganizer();

        cache()->forget("my-events-{$user->id}", $user->id);

        $orgas = $event->organizers()->get();
        $orgas = User::whereIn('id', $orgas->pluck('user_id'))->get();
        Notification::sendNow($orgas, new OrgaPromotion($event, $user));

        session()->flash('success', 'Cet utilisateur est maintenant organisateur·rice de l\'événement !');
        return redirect(route('event.attendees.manage', $event));
    }

    public function demoteYourselfFromOrganizers(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le modifier !');
        }
        $attendee = Attendee::where('event_id', $event->id)->where('user_id', auth()->id())->first();
        $attendee->is_organizer = false;
        $attendee->save();

        $userId = auth()->id();
        cache()->forget("my-events-{$userId}", $userId);

        $orgas = $event->organizers()->get();
        $orgas = User::whereIn('id', $orgas->pluck('user_id'))->get();
        Notification::sendNow($orgas, new OrgaDowngrade($event, auth()->user()));

        session()->flash('success', 'Tu n\'es plus organisateur·rice de l\'événement !');
        return redirect(route('events.show', $event));
    }

    public function setPaymentStatus(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le modifier !');
        }
        $user = User::find(request('user_id'));
        $status = request('has_paid');
        $attendee = Attendee::where('event_id', $event->id)->where('user_id', $user->id)->first();
        $attendee->setPaymentStatus($status);

        session()->flash('success', 'Le paiement de cet·te utilisateur·rice a bien été mis à jour !');
        return redirect(route('event.attendees.manage', $event));
    }
}
