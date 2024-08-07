<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use DB;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    public function __construct(protected CategoryRepositoryInterface $categoryRepository)
    {
    }

    public function create(array $data): Category
    {
        return DB::transaction(function () use ($data) {
            $category = $this->createCategory($data['name'], $data['category_id'] ?? null);

            if (!empty($data['subcategories'])) {
                $this->createSubcategories($category, $data['subcategories']);
            }

            return $category;
        });
    }

    public function update(Category $category, array $data): Category
    {
        return DB::transaction(function () use ($category, $data) {
            $this->categoryRepository->update($category, $data);

            return $category;
        });
    }

    private function createCategory(string $name, ?int $categoryId): Category
    {
        $existingCategory = $this->categoryRepository->findByNameAndCategoryId($name, $categoryId);

        if ($existingCategory) {
            throw ValidationException::withMessages(['name' => 'Category name must be unique within the same parent.']);
        }

        return $this->categoryRepository->create([
            Category::FIELD_NAME => $name,
            Category::FIELD_CATEGORY_ID => $categoryId
        ]);
    }

    private function createSubcategories(Category $category, array $subcategories): void
    {
        foreach ($subcategories as $subcategoryData) {
            $subcategory = $this->createCategory($subcategoryData['name'], $category->id);
            if (!empty($subcategoryData['subcategories'])) {
                $this->createSubcategories($subcategory, $subcategoryData['subcategories']);
            }
        }
    }
}
