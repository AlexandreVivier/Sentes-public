<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\miscellaneous>
 */
class MiscellaneousFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => \App\Models\User::factory(),
            'miscellaneous_list_id' => \App\Models\MiscellaneousList::factory(),
            'description' => $this->faker->text,
        ];
    }
}
