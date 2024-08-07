<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $service)
    {
    }

    public function index(): JsonResource
    {
        return CategoryResource::collection(
            Category::with('childrenCategories')->whereNull('category_id')->get()
        );
    }

    public function paginate(Request $request): JsonResource
    {
        $perPage = $request->input('perPage', 10);

        return CategoryResource::collection(
            Category::with('childrenCategories')->whereNull('category_id')->paginate($perPage)
        );
    }

    public function store(CreateOrUpdateCategoryRequest $request): JsonResource
    {
        $category = $this->service->create($request->validated());

        return new CategoryResource($category->load('childrenCategories'));
    }

    public function show(int $id): JsonResource
    {
        return new CategoryResource(Category::findOrFail($id));
    }

    public function update(CreateOrUpdateCategoryRequest $request, $id): JsonResource
    {
        $category = $this->service->update(
            Category::findOrFail($id),
            $request->validated()
        );

        return new CategoryResource($category->load('childrenCategories'));
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $categoryId = $category->id;

        $category->delete();

        return response()->json("Category with id {$categoryId} deleted");
    }
}
