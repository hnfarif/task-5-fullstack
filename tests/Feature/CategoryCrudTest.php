<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
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


    public function testCreateCategory(): void
    {
        $data = Category::factory()->create()->toArray();

        $response = $this->post('/categories', $data);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', $data);
    }

    public function testListAllCategories() : void
    {
        Category::factory()->count(5)->create();

        $response = $this->get('/categories');

        $response->assertStatus(200)
            ->assertViewIs('category.index')
            ->assertViewHas('categories');
    }

    public function testUpdateCategory() : void
    {
        $category = Category::factory()->create();

        $data = [
            'name' => $this->faker->sentence,
        ];

        $response = $this->put('/categories/' . $category->id, $data);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', $data);
    }

    public function testDeleteCategory() : void
    {
        $category = Category::factory()->create();

        $response = $this->delete('/categories/' . $category->id);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
