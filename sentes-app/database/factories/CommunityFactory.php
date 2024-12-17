<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $communityNames = [
            'Humanes',
            'Horlas',
            'Fées',
            'Corax',
            'Masques d\or',
            'Zombies',
            'Sédentaires',
            'Nomades',
            'Bannies',
            'Goupils',
            'Marchebranches',
            'Constructs',
            'Asraï',
            'Chimères',
            'Camp des rouges',
            'Camp des bleus',
            'Communauté de l\'anneau',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($communityNames),
            'description' => $this->faker->text,
            'community_list_id' => \App\Models\CommunityList::factory(),
            'author_id' => \App\Models\User::factory(),
            'individual' => $this->faker->sentence,
            'group' => $this->faker->sentence,
            'perspectives' => $this->faker->sentence,
            'highlights' => $this->faker->text,
        ];
    }
}
