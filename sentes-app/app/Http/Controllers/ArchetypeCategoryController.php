<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchetypeCategory;
use App\Models\ArchetypeList;

class ArchetypeCategoryController extends Controller
{
    public function index()
    {
        $archetypeCategories = ArchetypeCategory::all();
        return view('listables.archetypes.categories.index', compact('archetypeCategories'));
    }

    public function create()
    {
        return view('listables.archetypes.categories.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99'],
            'description' => ['required', 'min:3', 'max:255'],
            'author_id' => ['required'],
        ]);
        ArchetypeCategory::create($attributes);
        session()->flash('success', 'Nouvelle catégorie créée avec succès !');
        return redirect(route('archetypes.categories.index'));
    }

    public function edit(ArchetypeCategory $archetypeCategory)
    {
        $user = auth()->user();
        if ($archetypeCategory->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à modifier cette catégorie !');
            return redirect(route('archetypes.categories.index'));
        }
        return view('listables.archetypes.categories.edit', compact('archetypeCategory'));
    }

    public function update(ArchetypeCategory $archetypeCategory)
    {
        $user = auth()->user();
        if ($archetypeCategory->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à modifier cette catégorie !');
            return redirect(route('archetypes.categories.index'));
        }
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99'],
            'description' => ['required', 'min:3', 'max:255'],
            'author_id' => ['required'],
        ]);
        $archetypeCategory->update($attributes);
        session()->flash('success', 'Catégorie modifiée avec succès !');
        return redirect(route('archetypes.categories.index'));
    }

    public function destroy(ArchetypeCategory $archetypeCategory)
    {
        $user = auth()->user();
        if ($archetypeCategory->author_id !== $user->id && $user->is_admin !== 1) {
            session()->flash('error', 'Vous n\'êtes pas autorisé à supprimer cette catégorie !');
            return redirect(route('archetypes.categories.index'));
        }
        $archetypeCategory->delete();
        session()->flash('success', 'Catégorie supprimée avec succès !');
        return redirect(route('archetypes.categories.index'));
    }

    public function getArchetypeListsByCategory(ArchetypeCategory $archetypeCategory)
    {
        $archetypeCategories = ArchetypeCategory::all();
        $archetypeLists = ArchetypeList::where('archetype_category_id', $archetypeCategory->id)
            // ->filter(request(['search']))
            ->paginate(4)->withQueryString();
        return view('listables.archetypes.categories.show', compact('archetypeLists', 'archetypeCategory', 'archetypeCategories'));
    }
}
