<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:120', Rule::unique('categories', 'slug')->ignore($category)],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'string', 'max:2048'],
            'image_upload' => ['nullable', 'image', 'max:3072'],
            'is_featured' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $name = trim((string) $this->input('name'));
        $slug = trim((string) $this->input('slug'));
        $description = trim((string) $this->input('description'));
        $image = trim((string) $this->input('image'));

        $this->merge([
            'name' => $name,
            'slug' => Str::slug($slug !== '' ? $slug : $name),
            'description' => $description !== '' ? $description : null,
            'image' => $image !== '' ? $image : null,
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
