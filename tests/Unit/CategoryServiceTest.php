<?php

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    Category::factory(10)->create();

    $this->repository = Mockery::mock(CategoryRepositoryInterface::class);
    $this->service = new CategoryService($this->repository);
});

it('creates a category', function () {
    $data = [
        'name' => 'New Category',
        'category_id' => null
    ];

    $this->repository->shouldReceive('findByNameAndCategoryId')
        ->with('New Category', null)
        ->andReturn(null);

    $this->repository->shouldReceive('create')
        ->with(['name' => 'New Category', 'category_id' => null])
        ->andReturn(new Category(['name' => 'New Category']));

    $category = $this->service->create($data);

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->name)->toBe('New Category');
});

it('throws validation exception when category name is not unique', function () {
    $data = [
        'name' => 'Existing Category',
        'category_id' => null
    ];

    $this->repository->shouldReceive('findByNameAndCategoryId')
        ->with('Existing Category', null)
        ->andReturn(new Category(['name' => 'Existing Category']));

    $this->expectException(ValidationException::class);

    $this->service->create($data);
});

//it('updates a category', function () {
//    $data = [
//        'name' => 'Old Category',
//    ];
//
//    $this->repository->shouldReceive('create')
//        ->with(['name' => 'Old Category', 'category_id' => null])
//        ->andReturn(new Category(['name' => 'Old Category']));
//
//    $category = $this->service->create($data);
//
//    $this->repository->shouldReceive('findByNameAndCategoryId')
//        ->with('Updated Category', null)
//        ->andReturn(null);
//
//    $this->repository->shouldReceive('update')
//        ->with($category, ['name' => 'Updated Category'])
//        ->andReturn(true);
//
//    $updatedCategory = $this->service->update($category, ['name' => 'Updated Category']);
//
//    expect($updatedCategory)->toBeInstanceOf(Category::class)
//        ->and($updatedCategory->name)->toBe('Updated Category');
//});
