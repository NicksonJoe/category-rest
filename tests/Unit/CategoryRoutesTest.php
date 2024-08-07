<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can fetch paginated categories', function () {
    $response = $this->getJson('/api/categories/paginate?perPage=5');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'children_categories']
            ]
        ]);
});

it('can fetch all categories', function () {
    $response = $this->getJson('/api/categories');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'children_categories']
            ]
        ]);
});
