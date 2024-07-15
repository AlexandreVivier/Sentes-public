<?php

namespace Tests;

use App\Models\Event;
use App\Models\Location;
use App\Models\User;
use App\Models\Attendee;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createOrganizerWithLocationAndEvent()
    {
        // Créer un orga et se log
        $organizer = User::factory()->create([
            'login' => 'organizer'
        ]);
        $this->actingAs($organizer);

        // Créer un lieu pour le GN et créer un événement
        $location = Location::factory()->create();

        $this->post('/events/', [
            'title' => 'Test event',
            'description' => 'This is a test event',
            'start_date' => now()->addDay(),
            'location_id' => $location->id
        ]);

        $this->patch(route('events.update', 1), [
            'max_attendees' => 3,
        ]);
    }
}
