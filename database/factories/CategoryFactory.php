<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categoryId = $this->faker->optional()->randomElement(Category::pluck('id')->toArray());

        return [
            'name' => $this->faker->name(),
            'category_id' => $categoryId,
        ];
    }
}

