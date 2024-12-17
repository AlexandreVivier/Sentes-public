<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BackgroundList;

class BackgroundListController extends Controller
{
    public function index()
    {
        $backgroundList = BackgroundList::all();
        return view('listables.backgrounds.index', compact('backgroundList'));
    }

    public function create()
    {
        return view('listables.backgrounds.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
        ]);

        $backgroundList = BackgroundList::create($attributes);
        session()->flash('message', 'Liste de backgrounds créée !');
        return redirect()->route('backgrounds.list.show', $backgroundList->id);
    }

    public function show(BackgroundList $backgroundList)
    {
        $backgrounds = $backgroundList->backgrounds;
        return view('listables.backgrounds.background.index', compact('backgroundList', 'backgrounds'));
    }

    public function edit(BackgroundList $backgroundList)
    {
        return view('listables.backgrounds.edit', compact('backgroundList'));
    }

    public function update(BackgroundList $backgroundList)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
        ]);

        $backgroundList->update($attributes);
        session()->flash('message', 'Liste de backgrounds modifiée !');
        return redirect()->route('backgrounds.list.index');
    }

    public function destroy(BackgroundList $backgroundList)
    {
        $user = auth()->user();
        if ($backgroundList->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette liste de backgrounds, tu ne peux pas la supprimer.');
        }
        $backgroundList->delete();
        session()->flash('message', 'Liste de backgrounds supprimée !');
        return redirect()->route('backgrounds.list.index');
    }
}
