<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Event;
use App\Models\Location;
use App\Models\Attendee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Tests\TestCase;

class EventTest extends TestCase
{

    use RefreshDatabase;

    // public function setUp(): void
    // {
    //     parent::setUp();
    //     $this->createOrganizerWithLocationAndEvent();
    // }

    /** @test */
    public function visitor_user_cannot_create_event()
    {
        // log out the current user and reset the session
        Auth::logout();
        // Sans être loggé, aller sur la page de création d'événement
        $response = $this->get('/events/create');
        // Vérifier que l'utilisateur est redirigé vers la page de login
        $response->assertRedirect('/login');
    }

    /** @test */
    public function logged_verified_user_can_create_event()
    {
        $this->createOrganizerWithLocationAndEvent('loggedCreate', 'logged');
        // Vérifier que l'événement a bien été créé
        $this->assertDatabaseHas('events', [
            'title' => 'Test event loggedCreate',
            'description' => 'This is a test event'
        ]);
    }

    /** @test */
    public function only_verified_user_can_create_event()
    {
        // Créer un utilisateur
        $user = User::factory()->create([
            'login' => 'not_verified',
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
        $this->createOrganizerWithLocationAndEvent('verifiedUser', 'verified');



        $event = Event::where('title', 'Test event verifiedUser')->first();
        $attendeeCount = $event->attendee_count;

        $this->assertDatabaseHas('events', [
            'title' => 'Test event verifiedUser',
            'description' => 'This is a test event',
            'attendee_count' => $attendeeCount
        ]);
        // Créer un utilisateur non vérifié
        $user = User::factory()->create([
            'login' => 'not_verified2',
            'email_verified_at' => null
        ]);
        // Se connecter avec cet utilisateur
        $this->actingAs($user);

        // // Aller sur la page de l'événement et s'inscrire
        $request = $this->post(route('attendee.subscribe', $event));

        $request->assertSessionDoesntHaveErrors()
            ->assertRedirectToRoute('verification.notice');

        // // Vérifier dans la base de données que l'utilisateur n'a pas été ajouté à la liste des participants
        $this->assertDatabaseMissing('attendees', [
            'event_id' => $event->id,
            'user_id' => $user->id
        ]);

        // même test avec un utilisateur vérifié
        $user2 = User::factory()->create([
            'login' => 'verified',
        ]);

        // // Se connecter avec cet utilisateur
        $this->actingAs($user2);


        // // Aller sur la page de l'événement et s'inscrire
        $this
            ->post(route('attendee.subscribe', $event))
            ->assertSessionDoesntHaveErrors();

        $newAttendeeCount = $attendeeCount + 1;
        // Vérifier dans la base de données que l'utilisateur a bien été ajouté à la liste des participants
        $this->assertDatabaseHas("attendees", [
            'event_id' => $event->id,
            'user_id' => $user2->id
        ]);

        // Vérifier que le nombre de participants a bien été incrémenté
        $this->assertDatabaseHas("events", [
            'id' => $event->id,
            'attendee_count' => $newAttendeeCount
        ]);
    }

    /** @test */
    public function user_cannot_subscribe_to_an_event_already_full()
    {
        $this->createOrganizerWithLocationAndEvent('fullEvent', 'full');
        $event = Event::where('title', 'Test event fullEvent')->first();
        $event->max_attendees = 1;
        $event->save();

        // Créer un utilisateur
        $user = User::factory()->create([
            'login' => 'user_full',
        ]);
        // Se connecter avec cet utilisateur
        $this->actingAs($user);
        // Aller sur la page de l'événement et s'inscrire
        $this->post(route('attendee.subscribe', $event->id))
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('events.show', $event->id));
        // Vérifier dans la base de données que l'utilisateur n'a pas été ajouté à la liste des participants
        $this->assertDatabaseMissing("attendees", [
            'event_id' => $event->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function orga_can_see_them_event_in_organisations()
    {
        $this->createOrganizerWithLocationAndEvent('CheckOrga', 'Check');
        $event = Event::where('title', 'Test event CheckOrga')->first();
        $organizer = User::where('login', 'organizerCheck')->first();

        $this->get(route('user.organisations.index', $organizer->id))
            ->assertSee('Test event CheckOrga');
    }

    /** @test */
    public function orga_can_see_them_cancelled_event_in_organisations()
    {
        $this->createOrganizerWithLocationAndEvent('CancelledEvent', 'Cancelled');
        $event = Event::where('title', 'Test event CancelledEvent')->first();
        $organizer = User::where('login', 'organizerCancelled')->first();

        $this->actingAs($organizer);

        $this->patch(route('event.modify', $event->id), [
            'title' => 'Cancelled event',
            'description' => 'This is a test event',
            'start_date' => now()->addDay(),
            'location_id' => 1,
            'is_cancelled' => 1
        ])->assertSessionDoesntHaveErrors()
            ->assertStatus(302);

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'is_cancelled' => 1
        ]);

        $this->get(route('user.organisations.cancelled.index', $organizer->id))
            ->assertSee('Cancelled event');
    }

    /** @test */
    public function orga_can_see_them_pasts_event_in_organisations()
    {
        $this->createOrganizerWithLocationAndEvent('PastEvent', 'Past');
        $event = Event::where('title', 'Test event PastEvent')->first();
        $organizer = User::where('login', 'organizerPast')->first();

        $pastDate = now()->subDay(2);

        $event->start_date = $pastDate;
        $event->save();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'start_date' => $pastDate
        ]);

        $this->get(route('user.organisations.past.index', $organizer->id))
            ->assertSee('Test event PastEvent');
    }
}
