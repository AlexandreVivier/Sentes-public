<?php

namespace Tests\Feature;

use App\Models\Community;
use App\Models\CommunityList;
use App\Models\Content;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Event;
use App\Models\Ritual;
use App\Models\RitualList;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_organizers_can_access_the_content(): void
    {
        $this->withoutExceptionHandling();
        $this->createOrganizerWithLocationAndEvent('contentTest1', 'Content');
        $event = Event::where('title', 'Test event contentTest1')->first();
        $organizer = User::where('login', 'organizerContent')->first();

        $this->actingAs($organizer);

        $this->post(route('event.content.store', $event), [
            'title' => 'test title1',
            'description' => 'test description1',
            'type' => 'archetype',
            'event_id' => $event->id,
            'is_unique' => 1,
        ])->assertStatus(302);

        $this->post(route('event.content.store', $event), [
            'title' => 'test title2',
            'description' => 'test description2',
            'type' => 'rituels',
            'event_id' => $event->id,
            'is_unique' => 0,
        ])->assertStatus(302);

        $this->assertDatabaseHas('contents', [
            'type' => 'archetype',
        ]);

        $content = $event->contents->first();

        $this->delete(route('event.content.destroy', [$event, $content]))
            ->assertStatus(302);

        $this->assertDatabaseMissing('contents', [
            'type' => 'archetype',
        ]);
        //Créer rapidement des listes pour tester le contenu
        $ritualList = RitualList::factory()->create([
            'name' => 'Test list',
            'description' => 'Test description',
        ]);
        $ritualList2 = RitualList::factory()->create([
            'name' => 'Test list2',
            'description' => 'Test description2',
        ]);
        // dd($ritualList->id, $ritualList2->id);
        $communityList = CommunityList::factory()->create([
            'name' => 'Test list',
            'description' => 'Test description',
        ]);
        $content2 = $event->contents()->where('type', 'rituels')->first();
        $this->patch(route('content.table.update', [$event->id, $content2->id]), [
            'listable_id' => [$ritualList->id],
            'listable_type' => 'App\Models\RitualList',
            'content_id' => $content2->id,
        ])->assertStatus(302);

        $this->assertDatabaseHas('listables', [
            'listable_id' => $ritualList->id,
            'listable_type' => 'App\Models\RitualList',
        ]);

        $this->patch(route('content.table.update', [$event->id, $content2->id]), [
            'listable_id' => [$communityList->id],
            'listable_type' => 'App\Models\CommunityList',
            'content_id' => $content2->id,
        ])->assertRedirect(route('events.show', $event))
            ->assertSessionHas('message', 'Erreur : type de contenu incohérent');
        // Create a user and subscribe to the event
        $subscriber = User::factory()->create();
        $this->actingAs($subscriber);
        $this->post(route('attendee.subscribe', $event))
            ->assertStatus(302);

        // Try to access the content page assert abort 403
        $this->get(route('event.content.index', $event))
            ->assertRedirectToRoute('events.show', $event)
            ->assertSessionHas('message', 'Tu dois être orga de ce GN pour le modifier !');

        // Try to create content
        $this->get(route('event.content.create', $event))
            ->assertRedirectToRoute('events.show', $event)
            ->assertSessionHas('message', 'Tu dois être orga de ce GN pour le modifier !');

        $this->patch(route('content.table.update', [$event->id, $content2->id]), [
            'listable_id' => [$ritualList2->id],
            'listable_type' => 'App\Models\RitualList',
            'content_id' => $content2->id,
        ])->assertRedirect(route('events.show', $event))
            ->assertSessionHas('message', 'Tu dois être orga de ce GN pour le modifier !');

        $this->assertDatabaseMissing('listables', [
            'listable_id' => $ritualList2->id,
            'listable_type' => 'App\Models\RitualList',
        ]);
    }
}
