<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProductManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path('uploads/product-variants'));

        parent::tearDown();
    }

    public function test_admin_can_create_a_product_with_melamine_samples_and_variant_galleries(): void
    {
        $category = Category::query()->create([
            'name' => 'Oficinas',
            'slug' => 'oficinas',
            'description' => 'Linea de oficina.',
            'is_featured' => true,
        ]);

        $this->actingAs($this->adminUser())
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Escritorio Ejecutivo',
                'slug' => '',
                'sku' => 'ofi-001',
                'short_description' => 'Escritorio para gerencia.',
                'description' => 'Melamina premium con cajonera lateral.',
                'price' => '480.000,50',
                'lead_time_days' => 7,
                'image' => 'https://example.com/escritorio.jpg',
                'variants' => [
                    [
                        'name' => 'Roble Natural',
                        'swatch_image' => '',
                        'images' => [
                            'https://example.com/escritorio-roble-1.jpg',
                        ],
                    ],
                    [
                        'name' => 'Blanco Hueso',
                        'swatch_image' => 'https://example.com/melaminas/blanco-hueso.jpg',
                        'images' => [
                            'https://example.com/escritorio-blanco-1.jpg',
                        ],
                    ],
                ],
                'variant_swatch_uploads' => [
                    UploadedFile::fake()->image('roble-natural.jpg', 300, 300),
                ],
                'variant_gallery_uploads' => [
                    [
                        UploadedFile::fake()->image('roble-natural-2.jpg', 1200, 900),
                        UploadedFile::fake()->image('roble-natural-3.jpg', 1200, 900),
                    ],
                ],
                'is_active' => '1',
                'is_featured' => '1',
            ])
            ->assertRedirect();

        $product = Product::query()
            ->with(['colorVariants.galleryImages'])
            ->where('slug', 'escritorio-ejecutivo')
            ->firstOrFail();

        $this->assertSame('OFI-001', $product->sku);
        $this->assertSame('480000.50', $product->price);
        $this->assertSame('https://example.com/escritorio.jpg', $product->image);
        $this->assertSame(7, $product->lead_time_days);
        $this->assertTrue($product->is_active);
        $this->assertTrue($product->is_featured);

        $roble = $product->colorVariants->firstWhere('name', 'Roble Natural');
        $blanco = $product->colorVariants->firstWhere('name', 'Blanco Hueso');

        $this->assertNotNull($roble);
        $this->assertNotNull($blanco);
        $this->assertStringStartsWith('uploads/product-variants/swatches/', $roble->swatch_image_path);
        $this->assertCount(3, $roble->galleryImages);
        $this->assertSame('https://example.com/melaminas/blanco-hueso.jpg', $blanco->swatch_image_path);
        $this->assertCount(1, $blanco->galleryImages);
        $this->assertSame('https://example.com/escritorio-blanco-1.jpg', $blanco->galleryImages->first()->image_path);
    }

    public function test_public_product_page_uses_melamine_sample_and_availability_label(): void
    {
        $category = Category::query()->create([
            'name' => 'Living',
            'slug' => 'living',
            'description' => 'Linea living.',
            'is_featured' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Rack Visual',
            'slug' => 'rack-visual',
            'short_description' => 'Rack con imagen personalizada.',
            'description' => 'Producto para validar imagen publica.',
            'price' => 1500,
            'stock' => 4,
            'lead_time_days' => 7,
            'is_active' => true,
            'is_featured' => false,
        ]);

        $variant = $product->colorVariants()->create([
            'name' => 'Tabaco Terra',
            'slug' => 'tabaco-terra',
            'hex_color' => '#7A5A43',
            'swatch_image_path' => 'https://example.com/melaminas/tabaco-terra.jpg',
            'sort_order' => 0,
        ]);

        $variant->galleryImages()->createMany([
            [
                'image_path' => 'https://example.com/rack-visual-1.jpg',
                'alt_text' => 'Rack Visual 1',
                'sort_order' => 0,
            ],
            [
                'image_path' => 'https://example.com/rack-visual-2.jpg',
                'alt_text' => 'Rack Visual 2',
                'sort_order' => 1,
            ],
        ]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('https://example.com/rack-visual-1.jpg', false)
            ->assertSee('https://example.com/melaminas/tabaco-terra.jpg', false)
            ->assertSee('Melamina activa')
            ->assertSee('Tabaco Terra')
            ->assertSee('Disponible en 7 dias');
    }

    private function adminUser(): User
    {
        return User::query()->create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
