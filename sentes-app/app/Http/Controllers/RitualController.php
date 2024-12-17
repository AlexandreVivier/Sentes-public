<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ritual;
use App\Models\Event;
use App\Models\RitualList;

class RitualController extends Controller
{
    public function create(RitualList $ritualList)
    {
        return view('listables.rituals.ritual.create', compact('ritualList'));
    }

    public function store(RitualList $ritualList)
    {
        $user = auth()->user();
        if ($ritualList->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette liste de rituels, tu ne peux pas ajouter de rituel à cette liste.');
        }
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
            'ritual_list_id' => 'required',
        ]);
        Ritual::create($attributes);
        session()->flash('message', 'Rituel ajouté à la liste !');
        return redirect()->route('rituals.list.show', $ritualList->id);
    }

    public function edit(Ritual $ritual)
    {
        $user = auth()->user();
        if ($ritual->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de ce rituel, tu ne peux pas le supprimer.');
        }
        $ritualList = $ritual->list;
        return view('listables.rituals.ritual.edit', compact('ritual', 'ritualList'));
    }

    public function update(Ritual $ritual)
    {
        $user = auth()->user();
        if ($ritual->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de ce rituel, tu ne peux pas le supprimer.');
        }
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
            'ritual_list_id' => 'required',
        ]);
        $ritual->update($attributes);
        $ritualList = $ritual->list;
        session()->flash('message', 'Rituel modifié !');
        return redirect()->route('rituals.list.show', $ritualList->id);
    }

    public function destroy(Ritual $ritual)
    {
        $user = auth()->user();
        if ($ritual->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de ce rituel, tu ne peux pas le supprimer.');
        }
        $ritualList = $ritual->list;
        $ritual->delete();
        session()->flash('message', 'Rituel supprimé de la liste !');
        return redirect()->route('rituals.list.show', $ritualList->id);
    }
}
