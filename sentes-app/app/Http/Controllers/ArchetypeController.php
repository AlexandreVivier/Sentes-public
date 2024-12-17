<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchetypeList;
use App\Models\Archetype;
use App\Models\ArchetypeCategory;
use Illuminate\Validation\Rule;

class ArchetypeController extends Controller
{
    public function create(ArchetypeList $archetypeList)
    {
        return view('listables.archetypes.archetype.create', compact('archetypeList'));
    }

    public function store(ArchetypeList $archetypeList)
    {
        $user = auth()->user();
        if ($archetypeList->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas auteurice de cette liste !');
            return redirect(route('archetypes.list.show', $archetypeList->id));
        }
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99', Rule::unique('archetypes', 'name')],
            'description' => ['required', 'min:3', 'max:255'],
            'first_link' => ['required', 'min:3', 'max:255'],
            'second_link' => ['required', 'min:3', 'max:255'],
            'archetype_list_id' => ['required'],
            'author_id' => ['required'],
        ]);

        Archetype::create($attributes);
        // TODO Admin notification
        session()->flash('success', 'Nouvel archétype créé avec succès !');
        return redirect()->route('archetypes.list.show', $archetypeList->id);
    }

    public function edit(Archetype $archetype)
    {
        $user = auth()->user();
        if ($archetype->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas auteurice de cet archétype !');
            return redirect(route('archetypes.list.show', $archetype->archetype_list_id));
        }
        return view('listables.archetypes.archetype.edit', compact('archetype'));
    }

    public function update(Archetype $archetype)
    {
        $user = auth()->user();
        if ($archetype->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas auteurice de cet archétype !');
            return redirect(route('archetypes.list.show', $archetype->archetype_list_id));
        }
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99', Rule::unique('archetypes', 'name')->ignore($archetype->id)],
            'description' => ['required', 'min:3', 'max:255'],
            'first_link' => ['required', 'min:3', 'max:255'],
            'second_link' => ['required', 'min:3', 'max:255'],
            'archetype_list_id' => ['required'],
            'author_id' => ['required'],
        ]);
        $archetype->update($attributes);
        $archetypeListId = $archetype->archetype_list_id;
        // TODO Admin notification
        session()->flash('success', 'Archétype modifié avec succès !');
        return redirect()->route('archetypes.list.show', $archetypeListId);
    }

    public function destroy(Archetype $archetype)
    {
        $user = auth()->user();
        if ($archetype->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas auteurice de cet archétype !');
            return redirect(route('archetypes.list.show', $archetype->archetype_list_id));
        }
        $archetypeListId = $archetype->archetype_list_id;
        $archetype->delete();
        // TODO Admin notification
        session()->flash('success', 'Archétype supprimé avec succès !');
        return redirect(route('archetypes.list.show', $archetypeListId));
    }
}
