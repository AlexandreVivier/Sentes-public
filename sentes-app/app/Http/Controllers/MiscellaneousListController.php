<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MiscellaneousList;
use App\Models\MiscellaneousCategory;

class MiscellaneousListController extends Controller
{
    public function index()
    {
        $miscellaneousList = MiscellaneousList::all();
        return view('listables.miscellaneouses.lists.index', compact('miscellaneousList'));
    }

    public function show(MiscellaneousList $miscellaneousList)
    {
        $miscellaneous = $miscellaneousList->miscellaneous;
        return view('listables.miscellaneouses.miscellaneous.index', compact('miscellaneousList', 'miscellaneous'));
    }

    public function create()
    {
        $miscellaneousCategories = MiscellaneousCategory::all();
        return view('listables.miscellaneouses.lists.create', compact('miscellaneousCategories'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99'],
            'description' => ['required', 'min:3', 'max:255'],
            'miscellaneous_category_id' => ['required'],
            'author_id' => ['required'],
        ]);
        $miscellaneousList = MiscellaneousList::create($attributes);
        session()->flash('success', 'Nouvelle liste créée avec succès !');
        // dd($miscellaneousList->id);
        return redirect(route('miscellaneous.list.show', $miscellaneousList->id));
    }

    public function edit(MiscellaneousList $miscellaneousList)
    {
        $miscellaneousCategories = MiscellaneousCategory::all();
        return view('listables.miscellaneouses.lists.edit', compact('miscellaneousList', 'miscellaneousCategories'));
    }

    public function update(MiscellaneousList $miscellaneousList)
    {
        $user = auth()->user();
        if ($miscellaneousList->author_id !== $user->id && $user->is_admin === 0) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette liste, tu ne peux pas la modifier.');
        }
        $attributes = request()->validate([
            'name' => ['required', 'min:3', 'max:99'],
            'description' => ['required', 'min:3', 'max:255'],
            'miscellaneous_category_id' => ['required'],
            'author_id' => ['required'],
        ]);
        $miscellaneousList->update($attributes);
        session()->flash('success', 'Liste modifiée avec succès !');
        return redirect(route('miscellaneous.list.show', $miscellaneousList->id));
    }

    public function destroy(MiscellaneousList $miscellaneousList)
    {
        $user = auth()->user();
        if ($miscellaneousList->author_id !== $user->id && $user->is_admin === 0) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette liste, tu ne peux pas la supprimer.');
        }
        $miscellaneousList->delete();
        session()->flash('success', 'Liste supprimée avec succès !');
        return redirect(route('miscellaneous.list.index'));
    }
}
