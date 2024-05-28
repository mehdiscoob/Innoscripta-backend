<?php

namespace Article;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Article;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getting all articles.
     *
     * @return void
     */
    public function test_get_all_articles()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        Article::factory()->count(5)->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->get('/api/article');
        $response->assertStatus(200);
    }

    /**
     * Test getting a single article.
     *
     * @return void
     */
    public function test_get_single_article()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $article = Article::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->get("/api/article/$article->id");

        $response->assertStatus(200);
    }

    /**
     * Test creating a new article.
     *
     * @return void
     */
    public function test_create_article()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $article = Article::factory()->make()->attributesToArray();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->post('/api/article', $article);

        $response->assertStatus(201);
    }

    /**
     * Test updating an article.
     *
     * @return void
     */
    public function test_update_article()
    {
        $article = Article::factory()->create();
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $data = Article::factory()->make()->attributesToArray();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->put("/api/article/$article->id", $data);

        $response->assertStatus(200);
    }

    /**
     * Test deleting an article.
     *
     * @return void
     */
    public function test_delete_article()
    {
        $article = Article::factory()->create();
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->delete("/api/article/$article->id");

        $response->assertStatus(200);

        $this->assertSoftDeleted($article);
    }

}
