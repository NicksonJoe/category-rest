<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    Category::factory(10)->create();
});

it('can fetch a single category', function () {
    $category = Category::first();

    $response = $this->getJson("/api/categories/{$category->id}");

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
            ]
        ]);
});

it('can create a category', function () {
    $data = [
        'name' => 'New Category',
        'category_id' => null
    ];

    $response = $this->postJson('/api/categories', $data);

    $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'New Category',
            ]
        ]);
});

it('can update a category', function () {
    $category = Category::first();
    $data = [
        'name' => 'Updated Category'
    ];

    $response = $this->putJson("/api/categories/{$category->id}", $data);

    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $category->id,
                'name' => 'Updated Category'
            ]
        ]);
});

it('can delete a category', function () {
    $category = Category::first();

    $response = $this->deleteJson("/api/categories/{$category->id}");

    $response->assertStatus(200)
        ->assertExactJson([
            "Category with id {$category->id} deleted"
        ]);

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});
