<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_page_lists_products_and_filters_by_category(): void
    {
        $office = Category::query()->create([
            'name' => 'Oficinas',
            'slug' => 'oficinas',
            'description' => 'Espacios de trabajo.',
            'is_featured' => true,
        ]);

        $bedroom = Category::query()->create([
            'name' => 'Dormitorios',
            'slug' => 'dormitorios',
            'description' => 'Guardado y descanso.',
            'is_featured' => true,
        ]);

        Product::query()->create([
            'category_id' => $office->id,
            'name' => 'Escritorio Test',
            'slug' => 'escritorio-test',
            'short_description' => 'Escritorio para oficina.',
            'description' => 'Descripcion del escritorio.',
            'price' => 1000,
            'stock' => 3,
            'is_active' => true,
            'is_featured' => true,
        ]);

        Product::query()->create([
            'category_id' => $bedroom->id,
            'name' => 'Placard Test',
            'slug' => 'placard-test',
            'short_description' => 'Placard para dormitorio.',
            'description' => 'Descripcion del placard.',
            'price' => 2000,
            'stock' => 2,
            'is_active' => true,
            'is_featured' => false,
        ]);

        $this->get(route('products.index', ['categoria' => 'oficinas']))
            ->assertOk()
            ->assertSee('Escritorio Test')
            ->assertSee('Disponible en 7 dias')
            ->assertDontSee('Stock:')
            ->assertDontSee('Placard Test');
    }

    public function test_product_detail_page_shows_selected_product(): void
    {
        $category = Category::query()->create([
            'name' => 'Living',
            'slug' => 'living',
            'description' => 'Muebles de living.',
            'is_featured' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Rack Test',
            'slug' => 'rack-test',
            'short_description' => 'Rack para TV.',
            'description' => 'Pensado para organizar multimedia.',
            'price' => 3000,
            'stock' => 5,
            'is_active' => true,
            'is_featured' => true,
        ]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Rack Test')
            ->assertSee('Pensado para organizar multimedia.');
    }
}
