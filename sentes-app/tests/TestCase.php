<?php

namespace Tests;

use App\Models\Event;
use App\Models\Location;
use App\Models\User;
use App\Models\Attendee;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewEvent;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createOrganizerWithLocationAndEvent(String $title, String $login)
    {
        // Créer un orga et se log
        $organizer = User::factory()->create([
            'login' => 'organizer' . $login,
        ]);
        $this->actingAs($organizer);

        // Créer un lieu pour le GN et créer un événement
        $location = Location::factory()->create();

        $start_date = now()->addDay();

        $data = [
            '_token' => csrf_token(),
            'title' => 'Test event ' . $title,
            'description' => 'This is a test event',
            'start_date' => $start_date,
            'location_id' => $location->id
        ];

        $this->post(route('events.store'), $data)
            ->assertSessionDoesntHaveErrors();

        $event = Event::where('title', 'Test event ' . $title)->first();
        $this->patch(route('events.update', $event->id), [
            'max_attendees' => 3,
        ]);
    }

    public function createAdminUser(String $login)
    {
        return User::factory()->create([
            'login' => 'admin' . $login,
            'is_admin' => 1,
        ]);
    }
}
