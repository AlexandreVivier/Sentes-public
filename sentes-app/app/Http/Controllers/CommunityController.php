<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityList;
use App\Models\Community;

class CommunityController extends Controller
{
    public function create(CommunityList $communityList)
    {
        return view('listables.communities.community.create', compact('communityList'));
    }

    public function store(CommunityList $communityList)
    {
        $user = auth()->user();
        if ($communityList->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette liste de communautés, tu ne peux pas ajouter de communauté à cette liste.');
        }
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
            'community_list_id' => 'required',
            // 'individual' => 'required',
            // 'group' => 'required',
            // 'perspectives' => 'required',
            // 'highlights' => 'required',
        ]);
        Community::create($attributes);
        session()->flash('message', 'Communauté ajoutée à la liste !');
        return redirect()->route('communities.list.show', $communityList->id);
    }

    public function edit(Community $community)
    {
        $user = auth()->user();
        if ($community->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette communauté, tu ne peux pas la modifier.');
        }
        $communityList = $community->list;
        return view('listables.communities.community.edit', compact('community', 'communityList'));
    }

    public function update(Community $community)
    {
        $user = auth()->user();
        if ($community->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette communauté, tu ne peux pas la modifier.');
        }
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'author_id' => 'required',
            'community_list_id' => 'required',
            'individual' => 'nullable',
            'group' => 'nullable',
            'perspectives' => 'nullable',
            'highlights' => 'nullable',
        ]);
        $community->update($attributes);
        $communityList = $community->list;
        session()->flash('message', 'Communauté modifiée !');
        return redirect()->route('communities.list.show', $communityList->id);
    }

    public function destroy(Community $community)
    {
        $user = auth()->user();
        if ($community->author_id !== $user->id) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette communauté, tu ne peux pas la supprimer.');
        }
        $community->delete();
        session()->flash('message', 'Communauté supprimée !');
        return redirect()->route('communities.list.show', $community->list->id);
    }

    public function exportToCSV(CommunityList $communityList)
    {
        $communities = $communityList->communities;
        $filename = $communityList->name . '-communautes.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Nom', 'Description', 'Individuel', 'Groupe', 'Perspectives', 'Points forts']);
        foreach ($communities as $community) {
            fputcsv($handle, [$community->name, $community->description, $community->individual, $community->group, $community->perspectives, $community->highlights]);
        }
        fclose($handle);
        $headers = [
            'Content-Type' => 'text/csv',
        ];
        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }
}
