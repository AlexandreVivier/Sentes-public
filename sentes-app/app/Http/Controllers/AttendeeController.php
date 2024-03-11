<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;

class AttendeeController extends Controller
{

    public function subscribeToEvent(Event $event)
    {
        $user = auth()->user();
        $attendee = new Attendee();
        $attendee->event_id = $event->id;
        $attendee->user_id = $user->id;
        $attendee->has_payed = false;
        $attendee->is_organizer = false;
        $attendee->save();

        session()->flash('success', 'Tu es bien inscrit·e à l\'événement !');
        return redirect(route('events.show', $event));
    }

    public function unsubscribeFromEvent(Event $event)
    {
        $user = auth()->user();
        $attendee = Attendee::where('event_id', $event->id)->where('user_id', $user->id)->first();
        $attendee->delete();

        session()->flash('success', 'Tu es bien désinscrit·e de l\'événement !');
        return redirect(route('events.show', $event));
    }

    public function checkIfUserIsOrganizer($eventId)
    {
        $user = auth()->user();
        $event = Event::find($eventId);
        $attendee = Attendee::where('event_id', $event->id)->where('user_id', $user->id)->where('is_organizer', true)->first();
        if ($attendee) {
            return true;
        } else {
            return false;
        }
    }
}
