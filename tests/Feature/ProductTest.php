<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase, WithFaker;

    public function testProductCreation()
    {
        // Assuming you have authentication set up (e.g., using Sanctum)
        $user = \App\Models\User::factory()->create();

        // Use the authenticated user to create a product
        $response = $this->actingAs($user)
            ->postJson(route('products.store'), [
                'name' => $this->faker->name,
                'price' => $this->faker->randomFloat(2, 1, 100),
                'description' => $this->faker->sentence,
                'category_id' => 1, //
                'image' => $this->faker->image(public_path('/images/product'), 640, 480, null, false),
            ]);

        // Check if the product was created successfully
        $response->assertStatus(201);

        // Optionally, you can assert the structure or data returned in the response
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'price',
                'description',
                'category_id',
                'image',
                'created_at',
                'updated_at',
            ],
        ]);

        // Optionally, you can assert that the product is stored in the database
        $this->assertDatabaseHas('products', [
            'name' => $response['data']['name'],
            'price' => $response['data']['price'],
            'description' => $response['data']['description'],
            'category_id' => $response['data']['category_id'],
            'image' => $response['data']['image'],
        ]);
    }
}
