<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Location;
use App\Models\Event;
use App\Models\Attendee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // **************** USERS ****************

        User::factory()->create([
            'login' => 'Alexandre',
            'first_name' => 'Alex',
            'last_name' => 'Smith',
            'password' => 'Alexandre14!',
            'email' => 'testeur@gmail.com',
            'is_admin' => true,
            'accepted_terms' => true,
            'avatar_path' => 'users/avatars/blank-profile.png',
        ]);

        User::factory()->create([
            'login' => 'Thomas',
            'first_name' => 'Thomas',
            'last_name' => 'Smith',
            'password' => 'Thomas18!',
            'email' => 'orga@gmail.com',
            'accepted_terms' => true,
            'avatar_path' => 'users/avatars/blank-profile.png',
        ]);

        User::factory()->create([
            'login' => 'Turianne',
            'first_name' => 'Jean',
            'last_name' => 'Smith',
            'password' => 'CommonUser42!',
            'email' => 'user@gmail.com',
            'accepted_terms' => true,
            'avatar_path' => 'users/avatars/blank-profile.png',
        ]);

        User::factory()->create([
            'login' => 'Sylvain',
            'first_name' => 'Hacker',
            'last_name' => 'Smith',
            'password' => 'GeniusHacker42!',
            'email' => 'hacker@gmail.com',
            'accepted_terms' => true,
            'avatar_path' => 'users/avatars/blank-profile.png',
        ]);

        User::factory(10)->create();

        // **************** LOCATIONS ****************

        Location::factory()->create([
            'title' => 'Auberge du dragon Rouge',
            'number' => 12,
            'street' => 'rue de la paix',
            'city_name' => 'Lizio',
            'zip_code' => '75000',
        ]);

        Location::factory()->create([
            'title' => 'Ville Albertine',
            'number' => 1,
            'street' => 'rue de la guerre',
            'city_name' => 'Ambon',
            'zip_code' => '75000',
            'addon' => 'Apt 12',
        ]);

        Location::factory()->create([
            'title' => 'Chateau de la Roche',
            'number' => 13,
            'street' => 'rue de la soif',
            'city_name' => 'Le Mans',
            'zip_code' => '75000',
            'bis' => 'bis',
        ]);

        Location::factory()->create([
            'title' => 'Jardin',
            'number' => 12,
            'street' => 'impasse du jardin',
            'city_name' => 'Saulx les chartreux',
            'zip_code' => '75000',
            'addon' => 'privé',
        ]);

        Location::factory(2)->create();

        // **************** EVENTS ****************

        // Event in the past
        Event::factory()->create([
            'title' => 'Vinland',
            'description' => 'Une terre inconnu, des démons familiers',
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
            'has_payed' => true,
        ]);

        // Event with everything ok

        Event::factory()->create([
            'title' => 'Hiver Nucléaire',
            'description' => ' la tyrannie, la mort, la réconciliation',
            'start_date' => date('Y-m-d', strtotime('+1 day')),
            'location_id' => 3,
            'price' => 10,
            'max_attendees' => 25,
            'image_path' => 'events/images/hiver-nucleaire.png',
        ]);

        // Attendees and organizers for this event :
        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 1,
            'is_organizer' => true,
            'has_payed' => true,
        ]);


        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 3,
            'is_organizer' => true,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 4,
            'is_organizer' => true,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 5,
            'is_organizer' => false,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 3,
            'user_id' => 6,
            'is_organizer' => false,
            'has_payed' => false,
        ]);

        // Full event

        Event::factory()->create([
            'title' => 'La ZAD des tréfonds',
            'description' => 'Drames forestiers dans une réalité sorcière',
            'start_date' => date('Y-m-d', strtotime('+1 day')),
            'location_id' => 4,
            'price' => 10,
            'max_attendees' => 4,
            'image_path' => 'events/images/les-sentes.png',
        ]);

        Attendee::factory()->create([
            'event_id' => 4,
            'user_id' => 4,
            'is_organizer' => true,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 4,
            'user_id' => 5,
            'is_organizer' => true,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 4,
            'user_id' => 6,
            'is_organizer' => false,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 4,
            'user_id' => 7,
            'is_organizer' => false,
            'has_payed' => false,
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
            'has_payed' => true,
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
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 6,
            'is_organizer' => true,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 7,
            'is_organizer' => true,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 8,
            'is_organizer' => true,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 9,
            'is_organizer' => false,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 10,
            'is_organizer' => false,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 11,
            'is_organizer' => false,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 12,
            'is_organizer' => false,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 13,
            'is_organizer' => false,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 14,
            'is_organizer' => false,
            'has_payed' => true,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 2,
            'is_organizer' => false,
            'has_payed' => false,
        ]);

        Attendee::factory()->create([
            'event_id' => 5,
            'user_id' => 3,
            'is_organizer' => false,
            'has_payed' => false,
        ]);

        Event::factory(20)->create()->each(function ($event) {
            Attendee::factory()->create([
                'event_id' => $event->id,
                'user_id' => rand(1, 13),
                'is_organizer' => true,
                'has_payed' => true,
            ]);
        });
    }
}
