<?php

namespace App\Repositories;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function findByNameAndCategoryId(string $name, ?int $categoryId): ?Category;

    public function create(array $data): Category;

    public function find(int $id): ?Category;

    public function update(Category $category, array $data): bool;

    public function delete(Category $category): ?bool;
}
