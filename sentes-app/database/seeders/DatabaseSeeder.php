<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Location;
use App\Models\Event;
use App\Models\Attendee;
use App\Models\Archetype;
use App\Models\ArchetypeList;
use App\Models\ArchetypeCategory;
use App\Models\Community;
use App\Models\CommunityList;
use App\Models\RitualList;
use App\Models\Ritual;
use App\Models\Background;
use App\Models\BackgroundList;
use App\Models\Miscellaneous;
use App\Models\MiscellaneousCategory;
use App\Models\MiscellaneousList;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // **************** USERS ****************

        User::factory()->create([
            'login' => 'Alex_krill',
            'first_name' => 'Alex',
            'last_name' => 'Smith',
            'password' => 'Alexandre14!',
            'email' => 'testeur@gmail.com',
            'is_admin' => true,
            'accepted_terms' => true,
            'avatar_path' => 'images/static/blank-profile.png',
            'biography' => 'Je suis un organisateur et administrateur du site',
            'pronouns' => 'il/lui',
            'diet_restrictions' => 'Sans gluten',
            'allergies' => 'Arachides',
            'medical_conditions' => 'Diabète',
            'emergency_contact_name' => 'Jeanne',
            'emergency_contact_phone_number' => '0606060606',
            'red_flag_people' => 'Paul',
            'first_aid_qualifications' => 'PSC1',
            'phone_number' => '0606060606',
            'discord_username' => 'krill1984',
            'facebook_username' => 'Alex Krill',
            'trigger_warnings' => 'Attention, je refuse le jeu feel good',
        ]);

        User::factory()->create([
            'login' => 'ThomasMunier',
            'first_name' => 'Thomas',
            'last_name' => 'Smith',
            'password' => 'Thomas18!',
            'email' => 'orga@gmail.com',
            'accepted_terms' => true,
            'avatar_path' => 'images/static/blank-profile.png',
        ]);

        User::factory()->create([
            'login' => 'Turianne',
            'first_name' => 'Jean',
            'last_name' => 'Smith',
            'password' => 'CommonUser42!',
            'email' => 'user@gmail.com',
            'accepted_terms' => true,
            'avatar_path' => 'images/static/blank-profile.png',
        ]);

        User::factory()->create([
            'login' => 'SylvainP',
            'first_name' => 'Hacker',
            'last_name' => 'Smith',
            'password' => 'GeniusHacker42!',
            'email' => 'hacker@gmail.com',
            'accepted_terms' => true,
            'avatar_path' => 'images/static/blank-profile.png',
        ]);

        User::factory(10)->create();

        // **************** LOCATIONS ****************

        Location::factory()->create([
            'title' => 'Auberge du dragon Rouge',
            'number' => 12,
            'street' => 'rue de la paix',
            'city_name' => 'Lizio',
            'zip_code' => '33000',
        ]);

        Location::factory()->create([
            'title' => 'Ville Albertine',
            'number' => 1,
            'street' => 'rue de la guerre',
            'city_name' => 'Ambon',
            'zip_code' => '56000',
            'addon' => 'Apt 12',
        ]);

        Location::factory()->create([
            'title' => 'Chateau de la Roche',
            'number' => 13,
            'street' => 'rue de la soif',
            'city_name' => 'Le Mans',
            'zip_code' => '33000',
            'bis' => 'bis',
        ]);

        // Location::factory()->create([
        //     'title' => 'Jardin de Papy',
        //     'number' => 12,
        //     'street' => 'impasse du jardin',
        //     'city_name' => 'Saulx les chartreux',
        //     'zip_code' => '91000',
        //     'addon' => 'privé',
        // ]);

        Location::factory(2)->create();

        // **************** ARCHETYPES ****************

        // create 2 archetypes categories

        ArchetypeCategory::factory()->create([
            'name' => 'Missions de vie',
            'description' => 'Pour un GN Les Sentes',
            'author_id' => 1,
        ]);

        ArchetypeCategory::factory()->create([
            'name' => 'Destins',
            'description' => 'Pour un GN Les Sentes',
            'author_id' => 1,
        ]);
        // create 3 archetypes lists
        ArchetypeList::factory()->create([
            'name' => 'Fantasy',
            'description' => 'Missions de vie fantasy',
            'archetype_category_id' => 1,
            'author_id' => 1,
        ]);

        ArchetypeList::factory()->create([
            'name' => 'Science-fiction',
            'description' => 'Missions de vie science-fiction',
            'archetype_category_id' => 1,
            'author_id' => 1,
        ]);

        ArchetypeList::factory()->create([
            'name' => 'Horreur',
            'description' => 'Missions de vie horreur post-apo',
            'archetype_category_id' => 1,
            'author_id' => 1,
        ]);

        ArchetypeList::factory()->create([
            'name' => 'Fantasy',
            'description' => 'Destins fantasy',
            'archetype_category_id' => 2,
            'author_id' => 1,
        ]);

        ArchetypeList::factory()->create([
            'name' => 'Science-fiction',
            'description' => 'Destins science-fiction',
            'archetype_category_id' => 2,
            'author_id' => 1,
        ]);

        ArchetypeList::factory()->create([
            'name' => 'Horreur',
            'description' => 'Destins horreur post-apo',
            'archetype_category_id' => 2,
            'author_id' => 1,
        ]);

        // create 13 archetypes for each list

        Archetype::factory(13)->create([
            'archetype_list_id' => 1,
            'author_id' => 1,
        ]);

        Archetype::factory(13)->create([
            'archetype_list_id' => 2,
            'author_id' => 1,
        ]);

        Archetype::factory(13)->create([
            'archetype_list_id' => 3,
            'author_id' => 1,
        ]);

        Archetype::factory(13)->create([
            'archetype_list_id' => 4,
            'author_id' => 1,
        ]);

        Archetype::factory(13)->create([
            'archetype_list_id' => 5,
            'author_id' => 1,
        ]);

        Archetype::factory(13)->create([
            'archetype_list_id' => 6,
            'author_id' => 1,
        ]);

        // **************** COMMUNITIES ****************

        // create 3 community lists

        CommunityList::factory()->create([
            'name' => 'Fantasy',
            'description' => 'Communautés fantasy',
            'author_id' => 1,
        ]);

        CommunityList::factory()->create([
            'name' => 'Science-fiction',
            'description' => 'Communautés science-fiction',
            'author_id' => 1,
        ]);

        CommunityList::factory()->create([
            'name' => 'Horreur',
            'description' => 'Communautés horreur post-apo',
            'author_id' => 1,
        ]);

        // create 5 communities for each list

        Community::factory(5)->create([
            'community_list_id' => 1,
            'author_id' => 1,
        ]);

        Community::factory(5)->create([
            'community_list_id' => 2,
            'author_id' => 1,
        ]);

        Community::factory(5)->create([
            'community_list_id' => 3,
            'author_id' => 1,
        ]);

        // **************** RITUALS ****************

        // create 3 ritual lists

        RitualList::factory()->create([
            'name' => 'Fantasy',
            'description' => 'Rituels fantasy',
            'author_id' => 1,
        ]);

        RitualList::factory()->create([
            'name' => 'Science-fiction',
            'description' => 'Rituels science-fiction',
            'author_id' => 1,
        ]);

        RitualList::factory()->create([
            'name' => 'Horreur',
            'description' => 'Rituels horreur post-apo',
            'author_id' => 1,
        ]);

        // create 15 rituals for each list

        Ritual::factory(15)->create([
            'ritual_list_id' => 1,
            'author_id' => 1,
        ]);

        Ritual::factory(15)->create([
            'ritual_list_id' => 2,
            'author_id' => 1,
        ]);

        Ritual::factory(15)->create([
            'ritual_list_id' => 3,
            'author_id' => 1,
        ]);

        // **************** BACKGROUNDS ****************

        // create 2 background lists

        BackgroundList::factory()->create([
            'name' => 'hobbit',
            'description' => 'Backgrounds pour un GN Hobbit',
            'author_id' => 1,
        ]);

        BackgroundList::factory()->create([
            'name' => 'Anaon',
            'description' => 'Backgrounds pour le Pardon des Anaon',
            'author_id' => 1,
        ]);

        // create 5 backgrounds for each list

        Background::factory(5)->create([
            'background_list_id' => 1,
            'author_id' => 1,
        ]);

        Background::factory(5)->create([
            'background_list_id' => 2,
            'author_id' => 1,
        ]);

        // **************** MISCELLANEOUS ****************

        // create 3 miscellaneous categories

        MiscellaneousCategory::factory()->create([
            'name' => 'Contes',
            'description' => 'Contes pour un classique GN Les Sentes',
            'author_id' => 2,
        ]);

        MiscellaneousCategory::factory()->create([
            'name' => 'Souvenirs',
            'description' => 'Souvenirs pour un classique GN Les Sentes',
            'author_id' => 1,
        ]);

        MiscellaneousCategory::factory()->create([
            'name' => 'Questions',
            'description' => 'Questions pour un GN Sentes de type Entrevue',
            'author_id' => 4,
        ]);

        // create miscellaneous lists for each category

        MiscellaneousList::factory()->create([
            'name' => 'Fantasy',
            'description' => 'Contes fantasy pour un classique GN Les Sentes',
            'miscellaneous_category_id' => 1,
            'author_id' => 2,
        ]);

        MiscellaneousList::factory()->create([
            'name' => 'Viking',
            'description' => 'Contes nordiques pour un classique GN Les Sentes',
            'miscellaneous_category_id' => 1,
            'author_id' => 5,
        ]);

        MiscellaneousList::factory()->create([
            'name' => 'Science-fiction',
            'description' => 'Souvenirs science-fiction pour un classique GN Les Sentes',
            'miscellaneous_category_id' => 2,
            'author_id' => 2,
        ]);

        MiscellaneousList::factory()->create([
            'name' => 'Horreur',
            'description' => 'Souvenirs horreur pour un GN Sentes de type Entrevue',
            'miscellaneous_category_id' => 2,
            'author_id' => 4,
        ]);

        MiscellaneousList::factory()->create([
            'name' => 'western',
            'description' => 'Souvenirs westerns pour un classique GN Les Sentes',
            'miscellaneous_category_id' => 2,
            'author_id' => 1,
        ]);

        MiscellaneousList::factory()->create([
            'name' => 'Test Sédentaire',
            'description' => 'Questions Sédentaires pour un GN Sentes de type Entrevue',
            'miscellaneous_category_id' => 3,
            'author_id' => 2,
        ]);

        // create 5 miscellaneous for each list

        Miscellaneous::factory(5)->create([
            'miscellaneous_list_id' => 1,
            'author_id' => 2,
        ]);

        Miscellaneous::factory(5)->create([
            'miscellaneous_list_id' => 2,
            'author_id' => 5,
        ]);

        Miscellaneous::factory(5)->create([
            'miscellaneous_list_id' => 3,
            'author_id' => 2,
        ]);

        Miscellaneous::factory(5)->create([
            'miscellaneous_list_id' => 4,
            'author_id' => 4,
        ]);

        Miscellaneous::factory(5)->create([
            'miscellaneous_list_id' => 5,
            'author_id' => 1,
        ]);

        Miscellaneous::factory(15)->create([
            'miscellaneous_list_id' => 6,
            'author_id' => 2,
        ]);

        // **************** EVENTS ****************

        // Event in the past
        Event::factory()->create([
            'title' => 'Vinland',
            'description' => 'Une terre inconnue, des démons familiers',
            'start_date' => '2024-02-24',
            'end_date' => '2024-02-25',
            'location_id' => 2,
            'max_attendees' => 35,
            'image_path' => 'events/images/vinland.png',

        ]);

        Attendee::factory()->create([
            'event_id' => 1,
            'user_id' => 1,
            'is_organizer' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 1,
            'user_id' => 2,
            'is_organizer' => true,
        ]);

        // Event canceled
        Event::factory()->create([
            'title' => 'Compostelle',
            'description' => 'Sur la route',
            'start_date' => '2025-02-24',
            'end_date' => '2025-02-25',
            'location_id' => 3,
            'price' => 10,
            'max_attendees' => 50,
            'is_cancelled' => true,
            'image_path' => 'events/images/compostelle.png',
        ]);

        Attendee::factory()->create([
            'event_id' => 2,
            'user_id' => 3,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        // Event with everything ok

        Event::factory()->create([
            'title' => 'Asraï : bal du printemps',
            'description' => 'Bal d\'ouverture, toutes les créatures sont invitées',
            'start_date' => date('Y-m-d', strtotime('+7 day')),
            'location_id' => 3,
            'price' => 10,
            'max_attendees' => 25,
            'image_path' => 'events/images/asrai.png',
        ]);

        // Create archetype_list_event for this event with archetype_list_id = 1

        $event = Event::find(3);
        $list = ArchetypeList::find(1);

        // Assurez-vous que $event et $list existent
        // if ($event && $list) {
        //     $event->archetypesLists()->attach($list->id);
        // }



        // Attendees and organizers for this event :
        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 1,
            'is_organizer' => true,
            'has_paid' => true,
        ]);


        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 3,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 4,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 5,
            'is_organizer' => false,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 6,
            'is_organizer' => false,
            'has_paid' => false,
        ]);

        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 7,
            'is_organizer' => false,
            'has_paid' => false,
            'is_subscribed' => false,
        ]);

        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 8,
            'is_organizer' => false,
            'has_paid' => true,
            'is_subscribed' => false,
        ]);

        // Full event

        Event::factory()->create([
            'title' => 'La ZAD des tréfonds',
            'description' => 'Drames forestiers dans une réalité sorcière',
            'start_date' => date('Y-m-d', strtotime('+1 day')),
            'location_id' => 4,
            'price' => 10,
            'max_attendees' => 4,
            'image_path' => 'events/images/zad.jpg',
        ]);

        Attendee::factory()->create([
            'event_id' => 4,
            'user_id' => 4,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 4,
            'user_id' => 5,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 4,
            'user_id' => 6,
            'is_organizer' => false,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 4,
            'user_id' => 7,
            'is_organizer' => false,
            'has_paid' => false,
        ]);

        // Other events

        Event::factory()->create([
            'title' => 'Valerrance',
            'description' => 'Les équilibres sont rompus. Les petites histoires se jettent dans la grande.',
            'start_date' => '2024-10-24',
            'end_date' => '2024-10-25',
            'location_id' => 1,
            'max_attendees' => 50,
            'image_path' => 'events/images/valerrance.png',
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 1,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        // Event with 4 organizers and 10 attendees

        Event::factory()->create([
            'title' => 'Les Sentes',
            'description' => 'Drames forestiers dans une réalité sorcière',
            'start_date' => date('Y-m-d', strtotime('+1 day')),
            'location_id' => 5,
            'price' => 10,
            'max_attendees' => 25,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 5,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 6,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 7,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 8,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 9,
            'is_organizer' => false,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 10,
            'is_organizer' => false,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 11,
            'is_organizer' => false,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 12,
            'is_organizer' => false,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 13,
            'is_organizer' => false,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 14,
            'is_organizer' => false,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 2,
            'is_organizer' => false,
            'has_paid' => false,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 3,
            'is_organizer' => false,
            'has_paid' => false,
        ]);

        Event::factory()->create([
            'title' => 'Hiver Nucléaire',
            'description' => ' la tyrannie, la mort, la réconciliation',
            'start_date' => date('Y-m-d', strtotime('+1 day')),
            'location_id' => 3,
            'price' => 10,
            'max_attendees' => 25,
            'image_path' => 'events/images/hiver-nucleaire.png',
        ]);

        Attendee::factory()->create([
            'event_id' => 6,
            'user_id' => 1,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 6,
            'user_id' => 2,
            'is_organizer' => true,
            'has_paid' => true,
        ]);

        Event::factory(10)->create()->each(function ($event) {
            Attendee::factory()->create([
                'event_id' => $event->id,
                'user_id' => rand(1, 13),
                'is_organizer' => true,
                'has_paid' => true,
            ]);
        });

        foreach (Event::all() as $event) {
            $event->attendee_count = $event->getAttendeesCount();
            $event->save();
        }
    }
}
