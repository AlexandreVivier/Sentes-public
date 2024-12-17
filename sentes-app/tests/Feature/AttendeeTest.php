<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Event;
use App\Models\Location;
use Tests\TestCase;

class AttendeeTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function attendees_can_see_new_subscriber()
    {

        $this->createOrganizerWithLocationAndEvent('NewSubscriber', 'subscriber');
        $event = Event::where('title', 'Test event NewSubscriber')->first();
        $organizer = User::where('login', 'organizersubscriber')->first();

        // Créer un utilisateur / subscriber n°1
        $subscriber1 = User::factory()->create();
        // Se connecter avec cet utilisateur et s'inscrire à l'événement
        $this->actingAs($subscriber1);

        $event = Event::where('title', 'Test event NewSubscriber')->first();
        $this->post(route('attendee.subscribe', $event))
            ->assertStatus(302);


        // Vérifier que l'utilisateur voit bien l'organisateur et son login dans la liste des participants
        $this->get(route('events.show', $event))
            ->assertSee($organizer->login)
            ->assertSee($subscriber1->login)
            ->assertDontSee('Subscriber2');

        // Créer un utilisateur / subscriber n°2
        $subscriber2 = User::factory()->create(['login' => 'Subscriber2']);
        // Se connecter avec cet utilisateur et s'inscrire à l'événement
        $this->actingAs($subscriber2);
        $this->post(route('attendee.subscribe', $event))
            ->assertStatus(302);

        // désister de cet event :
        $this->delete(route('attendee.unsubscribe', $event))
            ->assertStatus(302);

        // Se connecter en orga et vérifier plusieurs choses
        // $organizer = User::find(1);
        $this->actingAs($organizer);
        // Vérifier que tout le monde est bien inscrit dans la liste des participants
        $this->get(route('events.show', $event))
            ->assertSee($subscriber1->login)
            ->assertSee($subscriber2->login);

        // Vérifier que le nombre de participants est bien de 3
        $this->assertEquals(3, Event::find($event->id)->attendees->count());

        // Accéder à la page gestion des participations et vérifier la présence des inscrits
        $this->get(route('event.attendees.manage', $event))
            ->assertSee($subscriber1->login)
            ->assertSee($subscriber2->login);

        // Revenir en subscriber1 et vérifier que subscriber2 n'est plus dans la liste des participants
        $this->actingAs($subscriber1);
        $this->get(route('events.show', $event))
            ->assertSee($organizer->login)
            ->assertDontSee($subscriber2->login)
            ->assertSee('Inscrit·es : 2 / 3');
    }
}
