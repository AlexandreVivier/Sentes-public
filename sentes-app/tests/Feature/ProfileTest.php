<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function publish_subscribe_character_creation_character_relation_double_relation()
    {
        $this->createOrganizerWithLocationAndEvent('profile', 'profile');
        $organizer = User::where('login', 'organizerprofile')->first();
        $event = Event::where('title', 'Test event profile')->first();
        $this->actingAs($organizer);

        $this->patch(route('event.profile.registrations', $event->id))
            ->assertSessionHas('success', 'Les inscriptions sont maintenant ouvertes !');

        $this->assertDatabaseHas('profiles', [
            'subscribing' => 1,
            'character_creation' => 0,
            'character_relation' => 0,
            'double_relation' => 0
        ]);

        $this->patch(route('event.profile.character.creation', $event->id))
            ->assertSessionHas('success', 'La création de perso est maintenant ouverte !');

        $this->assertDatabaseHas('profiles', [
            'subscribing' => 1,
            'character_creation' => 1,
            'character_relation' => 0,
            'double_relation' => 0
        ]);

        $this->patch(route('event.profile.character.relations', $event->id))
            ->assertSessionHas('success', 'Les relations sont maintenant ouvertes !');


        $this->assertDatabaseHas('profiles', [
            'subscribing' => 1,
            'character_creation' => 1,
            'character_relation' => 1,
            'double_relation' => 0
        ]);

        $this->patch(route('event.profile.double.link', $event->id))
            ->assertSessionHas('success', 'Les doubles liens sont maintenant autorisés !');

        $this->assertDatabaseHas('profiles', [
            'subscribing' => 1,
            'character_creation' => 1,
            'character_relation' => 1,
            'double_relation' => 1
        ]);

        $this->patch(route('event.profile.double.link', $event->id))
            ->assertSessionHas('success', 'Impossible de désactiver les doubles liens une fois activés !')
            ->assertRedirectToRoute('event.content.index', $event);


        $this->patch(route('event.profile.character.relations', $event->id))
            ->assertSessionHas('success', 'Les relations sont maintenant fermées !');

        $this->assertDatabaseHas('profiles', [
            'subscribing' => 1,
            'character_creation' => 1,
            'character_relation' => 0,
            'double_relation' => 1
        ]);

        $this->patch(route('event.profile.character.creation', $event->id))
            ->assertSessionHas('success', 'La création de perso est maintenant fermée !');

        $this->assertDatabaseHas('profiles', [
            'subscribing' => 1,
            'character_creation' => 0,
            'character_relation' => 0,
            'double_relation' => 1
        ]);

        $this->patch(route('event.profile.registrations', $event->id))
            ->assertSessionHas('success', 'Les inscriptions sont maintenant fermées !');

        $this->assertDatabaseHas('profiles', [
            'subscribing' => 0,
            'character_creation' => 0,
            'character_relation' => 0,
            'double_relation' => 1
        ]);
    }
}
