<?php

namespace Tests\Unit\UserPreference;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\UserPreference;

class UserPreferenceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getting all user preferences.
     *
     * @return void
     */
    public function test_get_all_user_preferences()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        UserPreference::factory()->count(5)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->get('/api/user-preference');

        $response->assertStatus(200);
    }

    /**
     * Test getting a single user preference.
     *
     * @return void
     */
    public function test_get_single_user_preference()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $userPreference = UserPreference::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->get("/api/user-preference/$userPreference->id");

        $response->assertStatus(200);
    }

    /**
     * Test creating a new user preference.
     *
     * @return void
     */
    public function test_create_user_preference()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $userPreference = UserPreference::factory()->make()->attributesToArray();
        $userPreference['preferred_sources'] = json_decode($userPreference['preferred_sources']);
        $userPreference['preferred_categories'] = json_decode($userPreference['preferred_categories']);
        $userPreference['preferred_authors'] = json_decode($userPreference['preferred_authors']);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->post('/api/user-preference', $userPreference);

        $response->assertStatus(201);
    }

    /**
     * Test updating a user preference.
     *
     * @return void
     */
    public function test_update_user_preference()
    {
        $userPreference = UserPreference::factory()->create();
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $data = UserPreference::factory()->make()->attributesToArray();
        $data['preferred_sources'] = json_decode($data['preferred_sources']);
        $data['preferred_categories'] = json_decode($data['preferred_categories']);
        $data['preferred_authors'] = json_decode($data['preferred_authors']);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->put("/api/user-preference/$userPreference->id", $data);

        $response->assertStatus(200);
    }

    /**
     * Test deleting a user preference.
     *
     * @return void
     */
    public function test_delete_user_preference()
    {
        $userPreference = UserPreference::factory()->create();
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->delete("/api/user-preference/$userPreference->id");

        $response->assertStatus(200);

        $this->assertSoftDeleted($userPreference);
    }
    /**
     * Test updating a user preference by user ID.
     *
     */
    public function test_update_user_preference_by_user_id()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
         UserPreference::factory()->create(['user_id'=>$user->id]);
        $data = UserPreference::factory()->make()->attributesToArray();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->put("/api/user-preference/user/$user->id", $data);

        $response->assertStatus(200);
    }

    /**
     * Test deleting user preferences by user ID.
     *
     */
    public function test_delete_user_preference_by_user_id()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;
        $userPreference = UserPreference::factory()->create(['user_id'=>$user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->delete("/api/user-preference/user/$user->id");

        $response->assertStatus(200);

        $this->assertSoftDeleted($userPreference);
    }

    /**
     * Test getting user preferences by user ID.
     *
     */
    public function test_get_user_preferences_by_user_id()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->get("/api/user-preference/user/$user->id");

        $response->assertStatus(200);
    }

    /**
     * Test getting personalized feed.
     *
     */
    public function test_get_personalized_feed()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        UserPreference::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token])->get('/api/article/personalized-feed');

        $response->assertStatus(200);
    }
}
