<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Event;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => ['required', 'max:99'],
            'number' => ['required', 'numeric', 'min:1'],
            'street' => ['required', 'max:99'],
            'city_name' => ['required', 'max:99'],
            'zip_code' => ['required', 'max:5'],
            'bis' => 'nullable',
            'addon' => 'nullable',
        ]);

        Location::create($attributes);

        return redirect(route('locations.index'));
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Location $location)
    {
        $attributes = request()->validate([
            'title' => ['required', 'max:99'],
            'number' => ['required', 'numeric', 'min:1'],
            'street' => ['required', 'max:99'],
            'city_name' => ['required', 'max:99'],
            'zip_code' => ['required', 'max:5'],
            'bis' => 'nullable',
            'addon' => 'nullable',
        ]);

        $location->update($attributes);

        return redirect(route('locations.index'));
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect(route('locations.index'));
    }

    public function getEventsByLocation(Location $location)
    {
        $events = Event::with(['organizers.user', 'attendees.user'])
            ->where('location_id', $location->id)
            ->where('is_cancelled', false)
            ->where('start_date', '>', now())
            ->filter(request(['search']))
            ->paginate(4)->withQueryString();


        $locations = cache()->rememberForever('locations', function () {
            return Location::all()
                ->sortByDesc('zip_code');
        });

        return view('locations.index', compact('location', 'events', 'locations'));
    }
}
