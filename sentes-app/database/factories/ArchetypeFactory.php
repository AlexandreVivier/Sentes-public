<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Archetype>
 */
class ArchetypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $archetypes_list_id = \App\Models\ArchetypeList::all()->pluck('id')->toArray();

        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->unique()->sentence,
            'first_link' => $this->faker->unique()->sentence,
            'second_link' => $this->faker->unique()->sentence,
            'archetype_list_id' => $this->faker->randomElement($archetypes_list_id),
            'author_id' => 1
        ];
    }
}
