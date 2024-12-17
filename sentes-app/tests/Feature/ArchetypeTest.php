<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\ArchetypeCategory;
use App\Models\ArchetypeList;
use App\Models\Archetype;
use App\Models\Event;
use Tests\TestCase;

class ArchetypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_new_list()
    {
        $this->withoutExceptionHandling();
        $this->createAdminUser('create');
        $admin = User::where('login', 'admincreate')->first();

        $this->post(route('archetypes.categories.store'), [
            '_token' => csrf_token(),
            'name' => 'Catégorie test',
            'description' => 'This is a test category',
            'author_id' => $admin->id,
        ])
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas('archetype_categories', [
            'name' => 'Catégorie test',
            'description' => 'This is a test category',
            'author_id' => $admin->id,
        ]);
        $archetypeCategory = ArchetypeCategory::where('name', 'Catégorie test')->first();
        $this->post(route('archetypes.list.store', $admin->id), [
            '_token' => csrf_token(),
            'name' => 'Liste test',
            'description' => 'This is a test list',
            'author_id' => $admin->id,
            'archetype_category_id' => $archetypeCategory->id,
        ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('archetype_lists', [
            'name' => 'Liste test',
            'description' => 'This is a test list',
            'author_id' => $admin->id,
            'archetype_category_id' => $archetypeCategory->id,
        ]);
        $archetypeList = ArchetypeList::where('name', 'Liste test')->first();
        $admin = User::where('login', 'admincreate')->first();
        $this->actingAs($admin);
        $this->post(route('archetypes.store', $archetypeList->id), [
            '_token' => csrf_token(),
            'name' => 'Archétype test',
            'description' => 'This is a test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $admin->id,
            'archetype_list_id' => $archetypeList->id,
        ])
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas('archetypes', [
            'name' => 'Archétype test',
            'description' => 'This is a test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $admin->id,
            'archetype_list_id' => $archetypeList->id,
        ]);
    }

    /** @test */
    public function admin_can_modify_archetypes()
    {
        $this->withoutExceptionHandling();
        $this->createAdminUser('modify');
        $admin = User::where('login', 'adminmodify')->first();

        $this->actingAs($admin);

        $this->post(route('archetypes.categories.store'), [
            '_token' => csrf_token(),
            'name' => 'Catégorie modif',
            'description' => 'This is a test category',
            'author_id' => $admin->id,
        ])
            ->assertSessionHasNoErrors();

        $archetypeCategory = ArchetypeCategory::where('name', 'Catégorie modif')->first();

        $this->post(route('archetypes.list.store', $admin->id), [
            '_token' => csrf_token(),
            'name' => 'Liste modif',
            'description' => 'This is a test list',
            'author_id' => $admin->id,
            'archetype_category_id' => $archetypeCategory->id,
        ])
            ->assertSessionHasNoErrors();

        $archetypeList = ArchetypeList::where('name', 'Liste modif')->first();

        $this->post(route('archetypes.store', $archetypeList->id), [
            '_token' => csrf_token(),
            'name' => 'Archétype modif',
            'description' => 'This is a test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $admin->id,
            'archetype_list_id' => $archetypeList->id,
        ])
            ->assertSessionHasNoErrors();

        $archetype = Archetype::where('name', 'Archétype modif')->first();

        // updates
        $this->patch(route('archetypes.update', $archetype->id), [
            '_token' => csrf_token(),
            'name' => 'Archétype modifié',
            'description' => 'This is a modified test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $admin->id,
            'archetype_list_id' => $archetypeList->id,
        ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('archetypes', [
            'name' => 'Archétype modifié',
            'description' => 'This is a modified test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $admin->id,
            'archetype_list_id' => $archetypeList->id,
        ]);

        $this->patch(route('archetypes.list.update', $archetypeList->id), [
            '_token' => csrf_token(),
            'name' => 'Liste modifiée',
            'description' => 'This is a modified test list',
            'author_id' => $admin->id,
            'archetype_category_id' => $archetypeCategory->id,
        ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('archetype_lists', [
            'name' => 'Liste modifiée',
            'description' => 'This is a modified test list',
            'author_id' => $admin->id,
            'archetype_category_id' => $archetypeCategory->id,
        ]);

        $this->patch(route('archetypes.categories.update', $archetypeCategory->id), [
            '_token' => csrf_token(),
            'name' => 'Catégorie modifiée',
            'description' => 'This is a modified test category',
            'author_id' => $admin->id,
        ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('archetype_categories', [
            'name' => 'Catégorie modifiée',
            'description' => 'This is a modified test category',
            'author_id' => $admin->id,
        ]);
    }

    /** @test */
    public function admin_can_delete_archetypes()
    {
        $this->withoutExceptionHandling();
        $this->createAdminUser('delete');
        $admin = User::where('login', 'admindelete')->first();

        $this->actingAs($admin);

        $this->post(route('archetypes.categories.store'), [
            '_token' => csrf_token(),
            'name' => 'Catégorie delete',
            'description' => 'This is a test category',
            'author_id' => $admin->id,
        ])
            ->assertSessionHasNoErrors();

        $archetypeCategory = ArchetypeCategory::where('name', 'Catégorie delete')->first();

        $this->post(route('archetypes.list.store', $admin->id), [
            '_token' => csrf_token(),
            'name' => 'Liste delete',
            'description' => 'This is a test list',
            'author_id' => $admin->id,
            'archetype_category_id' => $archetypeCategory->id,
        ])
            ->assertSessionHasNoErrors();

        $archetypeList = ArchetypeList::where('name', 'Liste delete')->first();

        $this->post(route('archetypes.store', $archetypeList->id), [
            '_token' => csrf_token(),
            'name' => 'Archétype delete',
            'description' => 'This is a test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $admin->id,
            'archetype_list_id' => $archetypeList->id,
        ])
            ->assertSessionHasNoErrors();

        $archetype = Archetype::where('name', 'Archétype delete')->first();

        $this->delete(route('archetypes.destroy', $archetype->id))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('archetypes', [
            'name' => 'Archétype delete',
            'description' => 'This is a test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $admin->id,
            'archetype_list_id' => $archetypeList->id,
        ]);

        $this->delete(route('archetypes.list.destroy', $archetypeList->id))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('archetype_lists', [
            'name' => 'Liste delete',
            'description' => 'This is a test list',
            'author_id' => $admin->id,
            'archetype_category_id' => $archetypeCategory->id,
        ]);

        $this->delete(route('archetypes.categories.destroy', $archetypeCategory->id))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('archetype_categories', [
            'name' => 'Catégorie delete',
            'description' => 'This is a test category',
            'author_id' => $admin->id,
        ]);
    }

    /** @test */
    public function organiser_can_create_an_archetype()
    {
        $this->withoutExceptionHandling();
        $this->createOrganizerWithLocationAndEvent('archetype_event', 'archetype_author');
        $event = Event::where('title', 'Test event archetype_event')->first();
        $organizer = User::where('login', 'organizerarchetype_author')->first();

        $this->actingAs($organizer);

        $this->get(route('event.content.index', $event))
            ->assertSee('contenus pour le GN');
        // créer la table de contenus
        $this->post(route('event.content.store', $event), [
            '_token' => csrf_token(),
            'title' => 'Contenu test',
            'description' => 'This is a test content',
            'is_unique' => 0,
            'type' => 'archetypes',
            'event_id' => $event->id,
        ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contents', [
            'title' => 'Contenu test',
            'description' => 'This is a test content',
            'is_unique' => 0,
            'type' => 'archetypes',
            'event_id' => $event->id,
        ]);

        $content = $event->contents()->where('title', 'Contenu test')->first();

        // créer la catégorie d'archétypes test_category
        $this->post(route('archetypes.categories.store'), [
            '_token' => csrf_token(),
            'name' => 'Catégorie orga test',
            'description' => 'This is a test category',
            'author_id' => $organizer->id,
        ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('archetype_categories', [
            'name' => 'Catégorie orga test',
            'description' => 'This is a test category',
            'author_id' => $organizer->id,
        ]);
        $testCat = ArchetypeCategory::where('name', 'Catégorie orga test')->first();

        // créer la liste d'archétypes test_orga_list

        $this->post(route('archetypes.list.store', $organizer->id), [
            '_token' => csrf_token(),
            'name' => 'Liste orga test',
            'description' => 'This is a test list',
            'author_id' => $organizer->id,
            'archetype_category_id' => $testCat->id,
        ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('archetype_lists', [
            'name' => 'Liste orga test',
            'description' => 'This is a test list',
            'author_id' => $organizer->id,
            'archetype_category_id' => $testCat->id,
        ]);
        $testList = ArchetypeList::where('name', 'Liste orga test')->first();

        // créer l'archétype test_orga_archetype

        $this->post(route('archetypes.store', $testList->id), [
            '_token' => csrf_token(),
            'name' => 'Archétype orga test',
            'description' => 'This is a test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $organizer->id,
            'archetype_list_id' => $testList->id,
        ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('archetypes', [
            'name' => 'Archétype orga test',
            'description' => 'This is a test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $organizer->id,
            'archetype_list_id' => $testList->id,
        ]);

        // ajouter cette liste d'archétypes au contenu
        $this->patch(route('content.table.update', [$event->id, $content->id]), [
            '_token' => csrf_token(),
            'content_id' => $content->id,
            'listable_id' => [$testList->id],
            'listable_type' => 'App\Models\ArchetypeList',
        ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('listables', [
            'listable_id' => $testList->id,
            'listable_type' => 'App\Models\ArchetypeList',
            'content_id' => $content->id,
        ]);

        // vérifier que l'archétype est bien dans la liste

        $this->get(route('event.content.index', $event))
            ->assertSee('Archétype orga test');

        // vérifier les créations de cet orga
        $this->get(route('event.content.creation.index', $organizer->id))
            ->assertSee('Liste orga test')
            ->assertSee('Catégorie orga test');

        // vérifier une suppression

        $this->delete(route('archetypes.destroy', $testList->id))
            ->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('archetypes', [
            'name' => 'Archétype orga test',
            'description' => 'This is a test archetype',
            'first_link' => 'Lorem ipsum dolor sit amet',
            'second_link' => 'consectetur adipiscing elit',
            'author_id' => $organizer->id,
            'archetype_list_id' => $testList->id,
        ]);
        $this->delete(route('archetypes.list.destroy', $testList->id))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('archetype_lists', [
            'name' => 'Liste orga test',
            'description' => 'This is a test list',
            'author_id' => $organizer->id,
            'archetype_category_id' => $testCat->id,
        ]);

        $this->delete(route('archetypes.categories.destroy', $testCat->id))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('archetype_categories', [
            'name' => 'Catégorie orga test',
            'description' => 'This is a test category',
            'author_id' => $organizer->id,
        ]);
    }

    // // test de cascade
    // $this->post(route('archetypes.categories.store'), [
    //     '_token' => csrf_token(),
    //     'name' => 'Catégorie delete 2',
    //     'description' => 'This is a test category',
    //     'author_id' => $admin->id,
    // ])
    //     ->assertSessionHasNoErrors();

    // $archetypeCategory = ArchetypeCategory::where('name', 'Catégorie delete 2')->first();

    // $this->post(route('archetypes.list.store', $admin->id), [
    //     '_token' => csrf_token(),
    //     'name' => 'Liste delete 2',
    //     'description' => 'This is a test list',
    //     'author_id' => $admin->id,
    //     'archetype_category_id' => $archetypeCategory->id,
    // ])
    //     ->assertSessionHasNoErrors();

    // $archetypeList = ArchetypeList::where('name', 'Liste delete 2')->first();

    // $this->post(route('archetypes.store', $archetypeList->id), [
    //     '_token' => csrf_token(),
    //     'name' => 'Archétype delete 2',
    //     'description' => 'This is a test archetype',
    //     'first_link' => 'Lorem ipsum dolor sit amet',
    //     'second_link' => 'consectetur adipiscing elit',
    //     'author_id' => $admin->id,
    //     'archetype_list_id' => $archetypeList->id,
    // ])
    //     ->assertSessionHasNoErrors();

    // $archetype = Archetype::where('name', 'Archétype delete 2')->first();

    // $this->delete(route('archetypes.categories.destroy', $archetypeCategory->id))
    //     ->assertSessionHasNoErrors();

    // $this->assertDatabaseMissing('archetype_categories', [
    //     'name' => 'Catégorie delete 2',
    //     'description' => 'This is a test category',
    //     'author_id' => $admin->id,
    // ]);

    // $this->assertDatabaseMissing('archetype_lists', [
    //     'name' => 'Liste delete 2',
    //     'description' => 'This is a test list',
    //     'author_id' => $admin->id,
    //     'archetype_category_id' => $archetypeCategory->id,
    // ]);

    // $this->assertDatabaseMissing('archetypes', [
    //     'name' => 'Archétype delete 2',
    //     'description' => 'This is a test archetype',
    //     'first_link' => 'Lorem ipsum dolor sit amet',
    //     'second_link' => 'consectetur adipiscing elit',
    //     'author_id' => $admin->id,
    //     'archetype_list_id' => $archetypeList->id,
    // ]);
}
