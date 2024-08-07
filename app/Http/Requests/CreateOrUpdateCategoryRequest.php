<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],
            'subcategories' => [
                'sometimes',
                'array',
            ],
            'subcategories.*.name' => [
                'required_with:subcategories',
                'string',
                'max:255',
            ],
            'subcategories.*.category_id' => [
                'nullable',
                'exists:categories,id',
            ],
            'subcategories.*.subcategories' => [
                'sometimes',
                'array',
            ],
        ];
    }
}
