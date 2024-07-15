<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Event;
use App\Models\Location;
use App\Models\Attendee;
use Illuminate\Support\Facades\Auth;

use Tests\TestCase;

class EventTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function visitor_user_cannot_create_event()
    {
        // Sans être loggé, aller sur la page de création d'événement
        $response = $this->get('/events/create');
        // Vérifier que l'utilisateur est redirigé vers la page de login
        $response->assertRedirect('/login');
    }

    /** @test */
    public function logged_user_can_create_event()
    {
        // Créer un utilisateur
        $user = User::factory()->create();
        // Se connecter avec cet utilisateur
        $this->actingAs($user);
        // Aller sur la page de création d'événement et créer un événement
        $response = $this->get('/events/create');
        $response->assertStatus(200);

        // Créer un lieu pour le GN
        $location = Location::factory()->create();
        // Créer un événement
        $this->post('/events', [
            'title' => 'Test event',
            'description' => 'This is a test event',
            'start_date' => now()->addDay(),
            'location_id' => $location->id
        ]);
        // Vérifier que l'événement a bien été créé
        $this->assertDatabaseHas("events", [
            'title' => 'Test event',
            'description' => 'This is a test event',
            'start_date' => now()->addDay(),
            'location_id' => $location->id
        ]);
    }

    /** @test */
    public function only_verified_user_can_create_event()
    {
        // Créer un utilisateur
        $user = User::factory()->create([
            'email_verified_at' => null
        ]);
        // Se connecter avec cet utilisateur
        $this->actingAs($user);
        // Aller sur la page de création d'événement et créer un événement
        $response = $this->get('/events/create');
        $response->assertRedirect('/email/verify');
    }

    /** @test */
    public function only_verified_user_can_subscribe_to_an_event()
    {
        $this->createOrganizerWithLocationAndEvent();

        // Créer un utilisateur
        $user = User::factory()->create([
            'email_verified_at' => null
        ]);
        // Se connecter avec cet utilisateur
        $this->actingAs($user);
        // Aller sur la page de l'événement et s'inscrire
        $this->post(route('attendee.subscribe', 1));
        // Vérifier dans la base de données que l'utilisateur n'a pas été ajouté à la liste des participants
        $this->assertDatabaseMissing("attendees", [
            'event_id' => 1,
            'user_id' => $user->id
        ]);

        // Vérifier que l'utilisateur est redirigé vers la page de vérification de l'email
        $this->post(route('attendee.subscribe', 1))
            ->assertRedirect('/email/verify');
    }

    /** @test */
    public function user_cannot_subscribe_to_an_event_already_full()
    {
        // Créer l'organisateur
        $organizer = User::factory()->create([
            'login' => 'organizer'
        ]);
        // Créer un lieu pour le GN
        $location = Location::factory()->create();
        // Créer un événement
        $event = Event::factory()->create([
            'title' => 'Event full',
            'description' => 'This is a test event',
            'start_date' => now()->addDay(),
            'location_id' => $location->id,
            'max_attendees' => 1
        ]);
        // Créer l'entrée dans la table Attendee pour l'organisateur
        Attendee::factory()->create([
            'event_id' => $event->id,
            'user_id' => $organizer->id,
            'is_organizer' => true,
            'has_paid' => true
        ]);
        // Mettre à jour l'event en conséquence
        $event->attendee_count += 1;
        $event->save();

        // Créer un utilisateur
        $user = User::factory()->create([
            'login' => 'user'
        ]);
        // Se connecter avec cet utilisateur
        $this->actingAs($user);
        // Aller sur la page de l'événement et s'inscrire
        $this->post(route('attendee.subscribe', $event->id));
        // Vérifier dans la base de données que l'utilisateur n'a pas été ajouté à la liste des participants
        $this->assertDatabaseMissing("attendees", [
            'event_id' => $event->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function orga_can_see_them_event_in_organisations()
    {
        $this->createOrganizerWithLocationAndEvent();

        $organizer = User::where('login', 'organizer')->first();
        $this->get(route('user.organisations.index', $organizer->id))
            ->assertSee('Test event');
    }

    /** @test */
    public function orga_can_see_them_cancelled_event_in_organisations()
    {
        $this->createOrganizerWithLocationAndEvent();

        $organizer = User::where('login', 'organizer')->first();
        $event = Event::where('title', 'Test event')->first();

        $this->patch(route('events.update', $event->id), [
            'is_cancelled' => true
        ]);

        $this->get(route('user.organisations.cancelled.index', $organizer->id))
            ->assertSee('Test event');
    }

    /** @test */
    public function orga_can_see_them_pasts_event_in_organisations()
    {
        $this->createOrganizerWithLocationAndEvent();

        $organizer = User::where('login', 'organizer')->first();
        $event = Event::where('title', 'Test event')->first();

        $this->patch(route('events.update', $event->id), [
            'start_date' => now()->subDay()
        ]);

        $this->get(route('user.organisations.past.index', $organizer->id))
            ->assertSee('Test event');
    }
}
