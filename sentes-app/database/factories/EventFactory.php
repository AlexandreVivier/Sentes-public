<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Location;
use App\Models\User;
use App\Models\Event;
use App\Models\Attendee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\events>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $eventDate = $this->faker->dateTimeBetween('now', '+1 year');

        return [
            'title' => $this->faker->text(20),
            'description' => $this->faker->text(99),
            'location_id' => $this->faker->randomElement(Location::pluck('id')->toArray()),
            'start_date' => $eventDate->modify('+1 day'),
            'price' => $this->faker->numberBetween(0, 50),
            'max_attendees' => $this->faker->numberBetween(1, 100),
            'image_path' => 'images/static/blank-event.png',
            'server_link' => 'https://discord.gg/bHP6D3q9fR',
            'tickets_link' => 'https://www.helloasso.com/',
            'file_path' => 'events/files/sentes.pdf',
        ];
    }
}
