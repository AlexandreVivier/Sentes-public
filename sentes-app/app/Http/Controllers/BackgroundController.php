<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BackgroundList;
use App\Models\Background;

class BackgroundController extends Controller
{
    public function create(BackgroundList $backgroundList)
    {
        return view('listables.backgrounds.background.create', compact('backgroundList'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
            'background_list_id' => 'required',
        ]);

        $background = Background::create($attributes);
        $backgroundList = $background->backgroundList;
        session()->flash('message', 'Liste de backgrounds créée !');
        return redirect()->route('backgrounds.list.show', $backgroundList->id);
    }

    public function edit(Background $background)
    {
        $user = auth()->user();
        if ($background->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de ce background, tu ne peux pas le modifier.');
        }
        // dd($background);
        $backgroundList = $background->backgroundList;
        return view('listables.backgrounds.background.edit', compact('background', 'backgroundList'));
    }

    public function update(Background $background)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
            'background_list_id' => 'required',
        ]);

        $background->update($attributes);
        session()->flash('message', 'Liste de backgrounds modifiée !');
        return redirect()->route('backgrounds.list.index');
    }

    public function destroy(Background $background)
    {
        $user = auth()->user();
        if ($background->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de ce background, tu ne peux pas le supprimer.');
        }
        $backgroundList = $background->backgroundList;
        $background->delete();
        session()->flash('message', 'Background supprimé !');
        return redirect()->route('backgrounds.list.show', $backgroundList->id);
    }
}
