<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->with(['category', 'colorVariants.galleryImages'])
            ->orderByDesc('is_active')
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->get();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::query()->orderBy('name')->get(),
            'product' => new Product(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $product = DB::transaction(function () use ($request): Product {
            $product = Product::query()->create($this->payload($request));
            $this->syncVariants($product, $request->validated('variants', []), $request);

            return $product;
        });

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Producto creado y listo para publicarse.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'categories' => Category::query()->orderBy('name')->get(),
            'product' => $product->load(['category', 'colorVariants.galleryImages']),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        DB::transaction(function () use ($product, $request): void {
            $product->update($this->payload($request));
            $this->syncVariants($product, $request->validated('variants', []), $request);
        });

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Producto actualizado.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->orderItems()->exists() || $product->quoteRequests()->exists()) {
            return redirect()
                ->route('admin.products.index')
                ->with('error', 'No se puede eliminar este producto porque ya tiene historial comercial asociado.');
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Producto eliminado.');
    }

    private function payload(ProductRequest $request): array
    {
        $payload = collect($request->validated())
            ->except([
                'image_upload',
                'variants',
                'variant_swatch_uploads',
                'variant_gallery_uploads',
            ])
            ->all();

        if ($request->hasFile('image_upload')) {
            $payload['image'] = $this->storeUploadedImage($request->file('image_upload'), 'products');
        }

        return $payload;
    }

    private function storeUploadedImage(UploadedFile $file, string $folder): string
    {
        $directory = public_path('uploads/'.$folder);
        File::ensureDirectoryExists($directory);

        $filename = Str::uuid()->toString().'.'.$file->extension();
        $file->move($directory, $filename);

        return 'uploads/'.$folder.'/'.$filename;
    }

    private function syncVariants(Product $product, array $variants, ProductRequest $request): void
    {
        $product->colorVariants()->delete();

        $sortOrder = 0;

        foreach ($variants as $variantIndex => $variant) {
            $swatchImagePath = $variant['swatch_image'] ?: null;

            if ($request->hasFile("variant_swatch_uploads.$variantIndex")) {
                $swatchImagePath = $this->storeUploadedImage(
                    $request->file("variant_swatch_uploads.$variantIndex"),
                    'product-variants/swatches',
                );
            }

            $colorVariant = $product->colorVariants()->create([
                'name' => $variant['name'],
                'slug' => Str::slug($variant['name']) ?: 'melamina-'.($sortOrder + 1),
                'hex_color' => '#D5C4B3',
                'swatch_image_path' => $swatchImagePath,
                'sort_order' => $sortOrder,
            ]);

            $galleryImages = collect($variant['images'] ?? [])
                ->filter()
                ->values()
                ->all();

            foreach (collect($request->file("variant_gallery_uploads.$variantIndex", []))->filter() as $uploadedImage) {
                $galleryImages[] = $this->storeUploadedImage($uploadedImage, 'product-variants/galleries');
            }

            foreach (array_values($galleryImages) as $imageIndex => $imagePath) {
                $colorVariant->galleryImages()->create([
                    'image_path' => $imagePath,
                    'alt_text' => $product->name.' en '.$variant['name'],
                    'sort_order' => $imageIndex,
                ]);
            }

            $sortOrder++;
        }
    }
}
