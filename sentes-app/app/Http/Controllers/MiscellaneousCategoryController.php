<?php

namespace App\Http\Controllers;

use App\Models\MiscellaneousCategory;
use Illuminate\Http\Request;

class MiscellaneousCategoryController extends Controller
{
    public function index()
    {
        $miscellaneousCategories = MiscellaneousCategory::all();
        return view('listables.miscellaneouses.categories.index', compact('miscellaneousCategories'));
    }

    public function getAllMiscellaneousListsByCategory(MiscellaneousCategory $miscellaneousCategory)
    {
        $miscellaneousCategories = MiscellaneousCategory::all();
        $miscellaneousList = $miscellaneousCategory->miscellaneousLists;
        return view('listables.miscellaneouses.categories.show', compact(
            'miscellaneousCategory',
            'miscellaneousCategories',
            'miscellaneousList'
        ));
    }

    public function create()
    {
        return view('listables.miscellaneouses.categories.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99'],
            'description' => ['required', 'min:3', 'max:255'],
            'author_id' => ['required'],
        ]);
        $miscellaneousCategory = MiscellaneousCategory::create($attributes);
        session()->flash('success', 'Nouvelle catégorie créée avec succès !');
        return redirect(route('miscellaneous.lists.categories.show', $miscellaneousCategory->id));
    }

    public function edit(MiscellaneousCategory $miscellaneousCategory)
    {
        return view('listables.miscellaneouses.categories.edit', compact('miscellaneousCategory'));
    }

    public function update(MiscellaneousCategory $miscellaneousCategory)
    {
        $user = auth()->user();
        if ($miscellaneousCategory->author_id !== $user->id && $user->is_admin === 0) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette catégorie, tu ne peux pas la modifier.');
        }
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99'],
            'description' => ['required', 'min:3', 'max:255'],
            'author_id' => ['required'],
        ]);
        $miscellaneousCategory->update($attributes);
        session()->flash('success', 'Catégorie modifiée avec succès !');
        return redirect(route('miscellaneous.categories.show', $miscellaneousCategory->id));
    }

    public function destroy(MiscellaneousCategory $miscellaneousCategory)
    {
        $user = auth()->user();
        if ($miscellaneousCategory->author_id !== $user->id && $user->is_admin === 0) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette catégorie, tu ne peux pas la supprimer.');
        }
        $miscellaneousCategory->delete();
        session()->flash('success', 'Catégorie supprimée avec succès !');
        return redirect(route('miscellaneous.categories.index'));
    }
}
