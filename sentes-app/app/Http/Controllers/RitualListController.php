<?php

namespace App\Http\Controllers;

use App\Models\RitualList;
use App\Models\Event;
use Illuminate\Http\Request;

class RitualListController extends Controller
{
    public function index()
    {
        $ritualList = RitualList::all();
        return view('listables.rituals.index', compact('ritualList'));
    }

    public function show(RitualList $ritualList)
    {
        $rituals = $ritualList->rituals;
        return view('listables.rituals.ritual.index', compact('ritualList', 'rituals'));
    }

    public function create()
    {
        return view('listables.rituals.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
        ]);
        $ritualList = RitualList::create($attributes);
        session()->flash('message', 'Liste de rituels créée !');
        return redirect()->route('rituals.list.show', $ritualList->id);
    }

    public function edit(RitualList $ritualList)
    {
        return view('listables.rituals.edit', compact('ritualList'));
    }

    public function update(RitualList $ritualList)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
        ]);
        $ritualList->update($attributes);
        session()->flash('message', 'Liste de rituels modifiée !');
        return redirect()->route('rituals.list.index');
    }

    public function destroy(RitualList $ritualList)
    {
        $user = auth()->user();
        if ($ritualList->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette liste de rituels, tu ne peux pas la supprimer.');
        }
        $ritualList->delete();
        session()->flash('message', 'Liste de rituels supprimée !');
        return redirect()->route('rituals.list.index');
    }
}
