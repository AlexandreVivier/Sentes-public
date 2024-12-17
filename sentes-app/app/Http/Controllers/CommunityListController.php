<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityList;

class CommunityListController extends Controller
{
    public function index()
    {
        $communityList = CommunityList::all();
        return view('listables.communities.index', compact('communityList'));
    }

    public function create()
    {
        return view('listables.communities.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
        ]);
        $communityList = CommunityList::create($attributes);
        session()->flash('message', 'Liste de communautés créée !');
        return redirect()->route('communities.list.show', $communityList->id);
    }

    public function show(CommunityList $communityList)
    {
        $communities = $communityList->communities;
        return view('listables.communities.community.index', compact('communityList', 'communities'));
    }

    public function edit(CommunityList $communityList)
    {
        return view('listables.communities.edit', compact('communityList'));
    }

    public function update(CommunityList $communityList)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
        ]);
        $communityList->update($attributes);
        session()->flash('message', 'Liste de communautés modifiée !');
        return redirect()->route('communities.list.index');
    }

    public function destroy(CommunityList $communityList)
    {
        $user = auth()->user();
        if ($communityList->author_id !== $user->id) {
            abort(403, 'Tu ne peux pas supprimer une liste de communautés que tu n\'as pas créée !');
        }
        $communityList->delete();
        session()->flash('message', 'Liste de communautés supprimée !');
        return redirect()->route('communities.list.index');
    }
}
