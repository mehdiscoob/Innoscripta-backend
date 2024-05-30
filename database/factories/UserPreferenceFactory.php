<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPreferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserPreference::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $categories = ['Technology', 'Business', 'Sports', 'Health', 'Science', 'General'];
        $sources = ['The New York Times', 'CNN', 'Fox News', 'Al Jazeera', 'The Guardian'];
        $authors = ['J.K. Rowling', 'Stephen King', 'George R.R. Martin', 'Agatha Christie',
            'Ernest Hemingway', 'Mark Twain', 'Jane Austen', 'William Shakespeare', 'Charles Dickens',
            'Harper Lee'
        ];
        return [
            'user_id' => User::factory(), // Assumes user factory exists and will create a user
            'preferred_sources' => json_encode($this->faker->randomElements($sources, 2)),
            'preferred_categories' => json_encode($this->faker->randomElements($categories, 2)),
            'preferred_authors' => json_encode($this->faker->randomElements($authors, 2)),
        ];
    }
}
