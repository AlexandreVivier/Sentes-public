<?php

namespace App\Http\Controllers;

use App\Models\Archetype;
use App\Models\ArchetypeList;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Event;
use App\Models\Ritual;
use App\Models\RitualList;
use App\Models\CommunityList;
use App\Models\BackgroundList;
use App\Models\Background;
use App\Models\Community;
use App\Models\MiscellaneousList;
use App\Models\Miscellaneous;
use App\Models\User;

class ContentController extends Controller
{
    public function index(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            session()->flash('message', 'Tu dois être orga de ce GN pour le modifier !');
            return redirect(route('events.show', $event));
        }
        $eventLists = $event->contents;
        $eventLists = $eventLists->pluck('id')->toArray();
        // $filteredList = ArchetypeList::whereDoesntHave('contents', function ($query) use ($eventLists) {
        //     $query->whereIn('content_id', $eventLists);
        // })->get();
        $filteredList = ArchetypeList::all();
        $allArchetypes = ArchetypeList::all();
        $allRituals = RitualList::all();
        $allCommunities = CommunityList::all();
        $allBackgrounds = BackgroundList::all();
        $allMiscellaneous = MiscellaneousList::all();
        $contents = $event->contents;
        return view('events.content', compact(
            'contents',
            'filteredList',
            'allBackgrounds',
            'allArchetypes',
            'allRituals',
            'allCommunities',
            'allMiscellaneous',
            'event'
        ));
    }

    public function create(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            session()->flash('message', 'Tu dois être orga de ce GN pour le modifier !');
            return redirect(route('events.show', $event));
        }
        return view('events.content', compact('event'));
    }

    public function store(Event $event)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            session()->flash('message', 'Tu dois être orga de ce GN pour le modifier !');
            return redirect(route('events.show', $event));
        }
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'event_id' => 'required|exists:events,id',
            'is_unique' => 'boolean',
            'type' => 'required',
            'is_public' => 'boolean',
            'number_of_selections' => 'integer',
            'max_selections' => 'nullable|integer',
        ]);
        $attributes['order'] = $event->contents->count() + 1;
        Content::create($attributes);
        session()->flash('message', 'Le contenu a bien été ajouté !');
        return redirect(route('event.content.index', $event));
    }

    public function destroy(Event $event, Content $content)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            session()->flash('message', 'Tu dois être orga de ce GN pour le modifier !');
            return redirect(route('events.show', $event));
        }
        $content->delete();
        session()->flash('message', 'Le contenu a bien été supprimé !');
        return redirect(route('event.content.index', $event));
    }

    public function edit(Event $event, Content $content)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            session()->flash('message', 'Tu dois être orga de ce GN pour le modifier !');
            return redirect(route('events.show', $event));
        }
        return view('events.content', compact('event', 'content'));
    }

    public function tableUpdate(Event $event, Content $content)
    {
        $orga = $event->organizers()->where('user_id', auth()->id())->first();
        if (!$orga) {
            session()->flash('message', 'Tu dois être orga de ce GN pour le modifier !');
            return redirect(route('events.show', $event));
        }
        $contentType = $content->type;
        $attributes = request()->validate([
            'listable_id' => 'required|array', // On attend un tableau d'IDs
            'listable_type' => 'required',
            'content_id' => 'required|exists:contents,id',
        ]);
        // on vérifie que le type de contenu est cohérent avec le type de liste et qu'il n'y a pas de tentative de forçage.
        switch ($attributes['listable_type']) {
            case 'App\Models\ArchetypeList':
                if ($contentType !== 'archetypes') {
                    session()->flash('message', 'Erreur : type de contenu incohérent');
                    return redirect(route('events.show', $event));
                }
                break;
            case 'App\Models\RitualList':
                if ($contentType !== 'rituels') {
                    session()->flash('message', 'Erreur : type de contenu incohérent');
                    return redirect(route('events.show', $event));
                }
                break;
            case 'App\Models\CommunityList':
                if ($contentType !== 'communautés') {
                    session()->flash('message', 'Erreur : type de contenu incohérent');
                    return redirect(route('events.show', $event));
                }
                break;
            case 'App\Models\BackgroundList':
                if ($contentType !== 'backgrounds') {
                    session()->flash('message', 'Erreur : type de contenu incohérent');
                    return redirect(route('events.show', $event));
                }
                break;
            case 'App\Models\MiscellaneousList':
                if ($contentType !== 'miscellaneous') {
                    session()->flash('message', 'Erreur : type de contenu incohérent');
                    return redirect(route('events.show', $event));
                }
                break;
            default:
                session()->flash('message', 'Erreur : type de contenu inconnu');
                return redirect(route('events.show', $event));
        }
        // on vérifie que le listable_id.* existe dans la table correspondante
        switch ($contentType) {
            case 'archetypes':
                $attributes['listable_id.*'] = 'exists:archetype_lists,id';
                break;
            case 'rituels':
                $attributes['listable_id.*'] = 'exists:ritual_lists,id';
                break;
            case 'communautés':
                $attributes['listable_id.*'] = 'exists:community_lists,id';
                break;
            case 'backgrounds':
                $attributes['listable_id.*'] = 'exists:background_lists,id';
                break;
            case 'miscellaneous':
                $attributes['listable_id.*'] = 'exists:miscellaneous_lists,id';
                break;
            default:
                session()->flash('message', 'Erreur : type de contenu inconnu');
                return redirect(route('events.show', $event));
        }
        switch ($attributes['listable_type']) {
            case 'App\Models\ArchetypeList':
                $content->archetypeLists()->sync($attributes['listable_id']);
                break;
            case 'App\Models\RitualList':
                $content->ritualLists()->sync($attributes['listable_id']);
                break;
            case 'App\Models\CommunityList':
                $content->communityLists()->sync($attributes['listable_id']);
                break;
            case 'App\Models\BackgroundList':
                $content->backgroundLists()->sync($attributes['listable_id']);
                break;
            case 'App\Models\MiscellaneousList':
                $content->miscellaneousLists()->sync($attributes['listable_id']);
                break;
            default:
                session()->flash('message', 'Erreur : type de contenu inconnu');
                return redirect(route('events.show', $event));
        }
        session()->flash('message', 'La table ' . $content->title . ' a bien été modifiée !');
        return redirect(route('event.content.index', $event->id));
    }

    public function creationIndex()
    {
        return view('events.content.index');
    }

    public function getCreationsByUser(User $user)
    {
        $userArchetypes = $user->archetypeLists;
        $userRituals = $user->ritualLists;
        $userCommunities = $user->communityLists;
        $userBackgrounds = $user->backgroundLists;
        $userArchetypesCategories = $user->archetypeCategories;
        $userMiscellaneousCategories = $user->miscellaneousCategories;
        $userMiscellaneous = $user->miscellaneousLists;
        return view('events.content.created', compact(
            'user',
            'userArchetypes',
            'userRituals',
            'userCommunities',
            'userBackgrounds',
            'userMiscellaneous',
            'userMiscellaneousCategories',
            'userArchetypesCategories'
        ));
    }
}
