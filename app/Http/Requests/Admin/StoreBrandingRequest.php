<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_logo_path' => ['nullable', 'string', 'max:2048'],
            'brand_logo_upload' => ['nullable', 'image', 'max:4096'],
            'clear_brand_logo' => ['boolean'],
            'home_hero_image_path' => ['nullable', 'string', 'max:2048'],
            'home_hero_image_upload' => ['nullable', 'image', 'max:6144'],
            'clear_home_hero_image' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $brandLogoPath = trim((string) $this->input('brand_logo_path'));
        $homeHeroImagePath = trim((string) $this->input('home_hero_image_path'));

        $this->merge([
            'brand_logo_path' => $brandLogoPath !== '' ? $brandLogoPath : null,
            'clear_brand_logo' => $this->boolean('clear_brand_logo'),
            'home_hero_image_path' => $homeHeroImagePath !== '' ? $homeHeroImagePath : null,
            'clear_home_hero_image' => $this->boolean('clear_home_hero_image'),
        ]);
    }
}
