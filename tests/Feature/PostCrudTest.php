<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use DatabaseTransactions;
    use WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = \App\Models\User::factory()->create();
        Auth::login($this->user);
    }

    public function testCreatePost()
    {
        $data = Post::factory()->create()->toArray();

        $response = $this->post('/posts', $data);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', $data);
    }

    public function testListAllPosts() : void
    {
        Post::factory()->count(5)->create();

        $response = $this->get('/posts');

        $response->assertStatus(200)
            ->assertViewIs('post.index')
            ->assertViewHas('posts');
    }

    public function testUpdatePost() : void
    {
        $post = Post::factory()->create();

        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'category_id' => 1,
        ];

        $response = $this->put('/posts/' . $post->id, $data);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', $data);
    }

    public function testDeletePost() : void
    {
        $post = Post::factory()->create();

        $response = $this->delete('/posts/' . $post->id);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
