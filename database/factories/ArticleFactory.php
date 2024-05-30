<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
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
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->text,
            'author' => $this->faker->randomElement($authors),
            'source' => $this->faker->randomElement($sources),
            'category' => $this->faker->randomElement($categories),
            'url' => $this->faker->url,
            'url_to_image' => $this->faker->imageUrl,
            'published_at' => date("Y-m-d H:i:s", time()),
        ];
    }
}

