<?php

namespace Tests\Feature;

use App\Http\Controllers\PostController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use DatabaseTransactions, WithFaker, InteractsWithSession;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');

        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');
    }

    public function testCreatePost()
    {
        $response = $this->post('api/v1/posts', [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'user_id' => 1,
            'category_id' => 1,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Post created successfully',
            ]);


    }

    public function testGetAllPosts()
    {
        $this->startSession();
        $response = $this->get('/api/v1/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'posts',
            ]);
    }

    public function testGetPostById()
    {
        $this->startSession();
        $post = \App\Models\Post::factory()->create();

        $response = $this->get('/api/v1/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'post'
                ]);

    }

    public function testUpdatePost()
    {
        $post = \App\Models\Post::factory()->create();

        $response = $this->put('/api/v1/posts/' . $post->id, [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Post updated successfully',
            ]);
    }

    public function testDeletePost()
    {
        $post = \App\Models\Post::factory()->create();

        $response = $this->delete('/api/v1/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Post deleted successfully',
            ]);
    }
}
