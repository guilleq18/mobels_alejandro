<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->withCount([
                'products as active_products_count' => fn ($query) => $query->active(),
            ])
            ->orderBy('name')
            ->get();

        $selectedCategory = $categories->firstWhere('slug', $request->string('categoria')->toString());

        $products = Product::query()
            ->with(['category', 'colorVariants.galleryImages'])
            ->active()
            ->when(
                $selectedCategory,
                fn ($query) => $query->whereBelongsTo($selectedCategory),
            )
            ->orderByDesc('is_featured')
            ->orderBy('price')
            ->get();

        return view('products.index', [
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load(['category', 'colorVariants.galleryImages']);

        $relatedProducts = Product::query()
            ->with(['category', 'colorVariants.galleryImages'])
            ->active()
            ->whereBelongsTo($product->category)
            ->whereKeyNot($product->getKey())
            ->orderByDesc('is_featured')
            ->orderBy('price')
            ->take(3)
            ->get();

        return view('products.show', [
            'galleryVariants' => $this->buildGalleryVariants($product),
            'instagramUrl' => config('store.instagram_url'),
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'whatsAppDefaultMessage' => trim((string) config('store.whatsapp_default_message')),
            'whatsAppNumber' => preg_replace('/\D+/', '', (string) config('store.whatsapp_number')),
        ]);
    }

    private function buildGalleryVariants(Product $product): array
    {
        $variants = $product->colorVariants
            ->map(function ($variant) use ($product): array {
                $images = $variant->galleryImages
                    ->map(fn ($image): array => [
                        'url' => $image->image_url,
                        'alt' => $image->alt_text ?: $product->name.' en '.$variant->name,
                    ])
                    ->values();

                if ($images->isEmpty()) {
                    $images = collect([[
                        'url' => $product->primary_image_url,
                        'alt' => $product->name.' en '.$variant->name,
                    ]]);
                }

                $firstImage = $images->first();

                return [
                    'id' => 'variant-'.$variant->id,
                    'name' => $variant->name,
                    'swatch_url' => $variant->swatch_image_url ?? ($firstImage['url'] ?? $product->primary_image_url),
                    'images' => $images->all(),
                ];
            })
            ->values();

        if ($variants->isNotEmpty()) {
            return $variants->all();
        }

        return [[
            'id' => 'variant-default-'.$product->getKey(),
            'name' => 'Melamina principal',
            'swatch_url' => $product->primary_image_url,
            'images' => [[
                'url' => $product->primary_image_url,
                'alt' => $product->name,
            ]],
        ]];
    }
}
