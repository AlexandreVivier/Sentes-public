<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Notifications\NewEvent;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function publishEvent(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour le publier !');
        }
        $profile = $event->profile;
        if ($profile->published) {
            session()->flash('success', 'Impossible de désactiver la publication une fois activée !');
        } else {
            $profile->update(['published' => 1]);
            session()->flash('success', 'Le GN est maintenant publié !');
            //Send notification to every user
            $users = User::all();
            $author = auth()->user();
            // Notification::sendNow($users, new NewEvent($event, $author));
            Notification::send($users, new NewEvent($event, $author));
            return redirect()->route('events.show', $event);
        }
    }

    public function openRegistrations(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour ouvrir les inscriptions !');
        }
        $profile = $event->profile;
        if ($profile->subscribing) {
            $profile->update(['subscribing' => 0]);
            session()->flash('success', 'Les inscriptions sont maintenant fermées !');
            return redirect()->route('event.content.index', $event);
        } else {
            $profile->update(['subscribing' => 1]);
            session()->flash('success', 'Les inscriptions sont maintenant ouvertes !');
            return redirect()->route('event.content.index', $event);
        }
    }

    public function openCharacterCreation(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour ouvrir la création de perso !');
        }
        $profile = $event->profile;
        if ($profile->character_creation) {
            $profile->update(['character_creation' => 0]);
            session()->flash('success', 'La création de perso est maintenant fermée !');
            return redirect()->route('event.content.index', $event);
        } else {
            $profile->update(['character_creation' => 1]);
            session()->flash('success', 'La création de perso est maintenant ouverte !');
            return redirect()->route('event.content.index', $event);
        }
    }

    public function openCharacterRelations(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour ouvrir les relations !');
        }
        $profile = $event->profile;
        if ($profile->character_relation) {
            $profile->update(['character_relation' => 0]);
            session()->flash('success', 'Les relations sont maintenant fermées !');
            return redirect()->route('event.content.index', $event);
        } else {
            $profile->update(['character_relation' => 1]);
            session()->flash('success', 'Les relations sont maintenant ouvertes !');
            return redirect()->route('event.content.index', $event);
        }
    }

    public function allowDoubleLink(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            abort(403, 'Tu dois être orga de ce GN pour autoriser les doubles liens !');
        }
        $profile = $event->profile;
        if ($profile->double_relation) {
            session()->flash('success', 'Impossible de désactiver les doubles liens une fois activés !');
            return redirect()->route('event.content.index', $event);
        } else {
            session()->flash('success', 'Les doubles liens sont maintenant autorisés !');
            $profile->update(['double_relation' => 1]);
            return redirect()->route('event.content.index', $event);
        }
    }
}
