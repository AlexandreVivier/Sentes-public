<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchetypeList;
use App\Models\Archetype;
use App\Models\ArchetypeCategory;
use Illuminate\Validation\Rule;

class ArchetypeListController extends Controller
{
    public function index()
    {
        $archetypeLists = ArchetypeList::all();
        $archetypeCategories = ArchetypeCategory::all();
        return view('listables.archetypes.list.index', compact('archetypeLists', 'archetypeCategories'));
    }

    public function show(ArchetypeList $archetypeList)
    {
        $archetypes = Archetype::where('archetype_list_id', $archetypeList->id)->get();
        return view('listables.archetypes.list.show', compact('archetypes', 'archetypeList'));
    }

    public function create()
    {
        $archetypeCategories = ArchetypeCategory::all();
        return view('listables.archetypes.list.create', compact('archetypeCategories'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99', Rule::unique('archetype_lists', 'name')],
            'description' => ['required', 'min:3', 'max:255'],
            'archetype_category_id' => ['required'],
            'author_id' => ['required'],
        ]);
        ArchetypeList::create($attributes);
        // TODO Admin notification
        $archetypeList = ArchetypeList::where('name', $attributes['name'])->first();
        session()->flash('success', 'Nouvelle liste créé avec succès !');
        return redirect()->route('archetypes.list.show', $archetypeList);
    }

    public function edit(ArchetypeList $archetypeList)
    {
        $user = auth()->user();
        if ($archetypeList->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas auteurice de cette liste !');
            return redirect(route('archetypes.list.index'));
        }
        $archetypeCategories = ArchetypeCategory::all();
        return view('listables.archetypes.list.edit', compact('archetypeList', 'archetypeCategories'));
    }

    public function update(ArchetypeList $archetypeList)
    {
        $user = auth()->user();
        if ($archetypeList->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas auteurice de cette liste !');
            return redirect(route('archetypes.list.index'));
        }
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99', Rule::unique('archetype_lists', 'name')->ignore($archetypeList->id)],
            'description' => ['required', 'min:3', 'max:255'],
            'author_id' => ['required'],
            'archetype_category_id' => ['required'],
        ]);
        $archetypeList->update($attributes);
        // TODO Admin notification
        session()->flash('success', 'Liste modifiée avec succès !');
        return redirect()->route('archetypes.list.show', $archetypeList->id);
    }

    public function destroy(ArchetypeList $archetypeList)
    {
        $user = auth()->user();
        if ($archetypeList->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas auteurice de cette liste !');
            return redirect(route('archetypes.list.index'));
        }
        $archetypeList->delete();
        // TODO Admin notification
        session()->flash('success', 'Liste supprimée avec succès !');
        return redirect()->route('archetypes.list.index');
    }
}
