<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class UserPreferenceFactory extends Factory
{
    protected $model = UserPreference::class;

    #[ArrayShape(['user_id' => "mixed", 'preferred_sources' => "false|string", 'preferred_categories' => "false|string", 'preferred_authors' => "false|string"])] public function
    definition():array
    {
        return [
            'user_id' => User::factory(), // Assumes user factory exists and will create a user
            'preferred_sources' => json_encode($this->faker->randomElements(['source1', 'source2', 'source3', 'source4'], 2)),
            'preferred_categories' => json_encode($this->faker->randomElements(['general', 'category2', 'category3', 'category4'], 2)),
            'preferred_authors' =>json_encode($this->faker->randomElements([$this->faker->name, $this->faker->name, $this->faker->name], 2)) ,
        ];
    }
}
