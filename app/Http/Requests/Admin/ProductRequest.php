<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:160'],
            'slug' => ['required', 'string', 'max:160', Rule::unique('products', 'slug')->ignore($product)],
            'sku' => ['nullable', 'string', 'max:120', Rule::unique('products', 'sku')->ignore($product)],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'lead_time_days' => ['required', 'integer', 'min:1', 'max:120'],
            'variants' => ['nullable', 'array'],
            'variants.*.name' => ['nullable', 'string', 'max:120'],
            'variants.*.swatch_image' => ['nullable', 'string', 'max:65535'],
            'variants.*.images' => ['nullable', 'array'],
            'variants.*.images.*' => ['nullable', 'string', 'max:65535'],
            'variant_swatch_uploads' => ['nullable', 'array'],
            'variant_swatch_uploads.*' => ['nullable', 'image', 'max:3072'],
            'variant_gallery_uploads' => ['nullable', 'array'],
            'variant_gallery_uploads.*' => ['nullable', 'array', 'max:5'],
            'variant_gallery_uploads.*.*' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'lead_time_days.required' => 'Definí en cuántos dias queda disponible este producto.',
            'variant_swatch_uploads.*.image' => 'La muestra de melamina tiene que ser una imagen válida.',
            'variant_gallery_uploads.*.max' => 'Podés subir hasta 5 imágenes por vez en cada melamina.',
            'variant_gallery_uploads.*.*.image' => 'Las imágenes del carrusel tienen que ser archivos de imagen válidos.',
            'variants.*.swatch_image.max' => 'La muestra de melamina es demasiado larga para guardarse como texto.',
            'variants.*.images.*.max' => 'Una de las imágenes del carrusel es demasiado larga para guardarse como texto.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $name = trim((string) $this->input('name'));
        $slug = trim((string) $this->input('slug'));
        $sku = trim((string) $this->input('sku'));
        $description = trim((string) $this->input('description'));
        $stock = $this->input('stock');
        $variants = collect($this->input('variants', []))
            ->map(function (mixed $variant): array {
                $variant = is_array($variant) ? $variant : [];

                return [
                    'name' => trim((string) ($variant['name'] ?? '')),
                    'swatch_image' => trim((string) ($variant['swatch_image'] ?? '')),
                    'images' => collect($variant['images'] ?? [])
                        ->map(fn (mixed $image): string => trim((string) $image))
                        ->filter()
                        ->values()
                        ->all(),
                ];
            })
            ->filter(function (array $variant, int|string $index): bool {
                $hasSwatchUpload = $this->hasFile("variant_swatch_uploads.$index");
                $galleryUploads = collect($this->file("variant_gallery_uploads.$index", []))->filter();

                return $variant['name'] !== ''
                    || $variant['swatch_image'] !== ''
                    || $variant['images'] !== []
                    || $hasSwatchUpload
                    || $galleryUploads->isNotEmpty();
            })
            ->all();

        $this->merge([
            'name' => $name,
            'slug' => Str::slug($slug !== '' ? $slug : $name),
            'sku' => $sku !== '' ? strtoupper($sku) : null,
            'description' => $description !== '' ? $description : null,
            'price' => $this->normalizePrice($this->input('price')),
            'stock' => $stock === null || $stock === '' ? 0 : (int) $stock,
            'lead_time_days' => max(1, (int) $this->input('lead_time_days', 7)),
            'variants' => $variants,
            'is_active' => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            foreach ($this->normalizedVariants() as $index => $variant) {
                $hasSwatchUpload = $this->hasFile("variant_swatch_uploads.$index");
                $galleryUploads = collect($this->file("variant_gallery_uploads.$index", []))->filter();
                $hasAnyVariantInput = $variant['name'] !== ''
                    || $variant['swatch_image'] !== ''
                    || $variant['images'] !== []
                    || $hasSwatchUpload
                    || $galleryUploads->isNotEmpty();

                if (! $hasAnyVariantInput) {
                    continue;
                }

                if ($variant['name'] === '') {
                    $validator->errors()->add("variants.$index.name", 'Cada melamina necesita un nombre visible.');
                }

                if ($variant['swatch_image'] === '' && ! $hasSwatchUpload) {
                    $validator->errors()->add("variants.$index.swatch_image", 'Cada melamina necesita una imagen de muestra.');
                }

                if ($variant['images'] === [] && $galleryUploads->isEmpty()) {
                    $validator->errors()->add("variants.$index.images", 'Cada melamina necesita al menos una imagen para el carrusel.');
                }
            }
        });
    }

    private function normalizePrice(mixed $value): mixed
    {
        if (! is_string($value)) {
            return $value;
        }

        $value = preg_replace('/\s+/', '', trim($value)) ?? '';

        if ($value === '') {
            return $value;
        }

        if (str_contains($value, ',') && str_contains($value, '.')) {
            return str_replace(',', '.', str_replace('.', '', $value));
        }

        if (str_contains($value, ',')) {
            return str_replace(',', '.', $value);
        }

        if (substr_count($value, '.') > 1) {
            return str_replace('.', '', $value);
        }

        return $value;
    }

    private function normalizedVariants(): array
    {
        return collect($this->input('variants', []))
            ->map(function (mixed $variant): array {
                $variant = is_array($variant) ? $variant : [];

                return [
                    'name' => trim((string) ($variant['name'] ?? '')),
                    'swatch_image' => trim((string) ($variant['swatch_image'] ?? '')),
                    'images' => collect($variant['images'] ?? [])
                        ->map(fn (mixed $image): string => trim((string) $image))
                        ->filter()
                        ->values()
                        ->all(),
                ];
            })
            ->all();
    }
}
