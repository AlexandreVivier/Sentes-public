<?php

namespace App\Http\Controllers;

use App\Models\MiscellaneousList;
use App\Models\Miscellaneous;
use Illuminate\Http\Request;

class MiscellaneousController extends Controller
{
    public function create(MiscellaneousList $miscellaneousList)
    {
        $user = auth()->user();
        if ($user->id !== $miscellaneousList->author_id && $user->is_admin === 0) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette liste de d\'éléments !');
        }
        return view('listables.miscellaneouses.miscellaneous.create', compact('miscellaneousList'));
    }

    public function store(MiscellaneousList $miscellaneousList)
    {
        $user = auth()->user();
        if ($user->id !== $miscellaneousList->author_id && $user->is_admin === 0) {
            abort(403, 'Tu n\'es pas l\'auteurice de cette liste d\'éléments !');
        }
        $attributes = request()->validate([
            'description' => ['required', 'min:3', 'max:255'],
            'author_id' => ['required'],
            'miscellaneous_list_id' => ['required'],
        ]);
        Miscellaneous::create($attributes);
        session()->flash('success', 'Nouvel élément créé avec succès !');
        return redirect(route('miscellaneous.list.show', $miscellaneousList->id));
    }

    public function edit(Miscellaneous $miscellaneous)
    {
        $user = auth()->user();
        if ($user->id !== $miscellaneous->author_id && $user->is_admin === 0) {
            abort(403, 'Tu n\'es pas l\'auteurice de cet élément !');
        }
        $miscellaneousList = $miscellaneous->miscellaneousList;
        return view('listables.miscellaneouses.miscellaneous.edit', compact('miscellaneous', 'miscellaneousList'));
    }

    public function update(Miscellaneous $miscellaneous)
    {
        $user = auth()->user();
        if ($user->id !== $miscellaneous->author_id && $user->is_admin === 0) {
            abort(403, 'Tu n\'es pas l\'auteurice de cet élément !');
        }
        $attributes = request()->validate([
            'description' => ['required', 'min:3', 'max:255'],
            'author_id' => ['required'],
            'miscellaneous_list_id' => ['required'],
        ]);
        $miscellaneous->update($attributes);
        $miscellaneousList = $miscellaneous->miscellaneousList;
        session()->flash('success', 'Elément modifié avec succès !');
        return redirect(route('miscellaneous.list.show', $miscellaneousList->id));
    }

    public function destroy(Miscellaneous $miscellaneous)
    {
        $user = auth()->user();
        if ($user->id !== $miscellaneous->author_id && $user->is_admin === 0) {
            abort(403, 'Tu n\'es pas l\'auteurice de cet élément !');
        }
        $miscellaneousList = $miscellaneous->miscellaneousList;
        $miscellaneous->delete();
        session()->flash('success', 'Elément supprimé avec succès !');
        return redirect(route('miscellaneous.list.show', $miscellaneousList->id));
    }

    public function exportToCSV(MiscellaneousList $miscellaneousList)
    {
        $miscellaneouses = $miscellaneousList->miscellaneous;
        $filename = $miscellaneousList->name . '-divers.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Description',]);
        foreach ($miscellaneouses as $miscellaneous) {
            fputcsv($handle, [$miscellaneous->description]);
        }
        fclose($handle);
        $headers = [
            'Content-Type' => 'text/csv',
        ];
        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }
}
