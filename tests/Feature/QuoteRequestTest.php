<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_page_shows_whatsapp_cta_when_number_is_configured(): void
    {
        config()->set('store.whatsapp_number', '+54 9 383 456 7890');

        $product = $this->createProduct();

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Pedir por WhatsApp')
            ->assertSee('https://wa.me/5493834567890', false);
    }

    public function test_quote_request_can_be_submitted_from_product_detail(): void
    {
        $product = $this->createProduct();

        $this->post(route('products.quote-requests.store', $product), [
            'customer_name' => 'Juan Perez',
            'phone' => '3834 123456',
            'email' => 'juan@example.com',
            'city' => 'Valle Viejo',
            'project_details' => 'Necesito adaptar este mueble a una pared de 2,40 m y revisar opciones de color.',
        ])->assertRedirect(route('products.show', $product).'#presupuesto');

        $this->assertDatabaseHas('quote_requests', [
            'product_id' => $product->id,
            'customer_name' => 'Juan Perez',
            'phone' => '3834 123456',
            'city' => 'Valle Viejo',
            'status' => 'pending',
        ]);
    }

    public function test_quote_request_requires_core_fields(): void
    {
        $product = $this->createProduct();

        $this->from(route('products.show', $product).'#presupuesto')
            ->post(route('products.quote-requests.store', $product), [
                'customer_name' => '',
                'phone' => '',
                'project_details' => '',
            ])
            ->assertRedirect(route('products.show', $product).'#presupuesto')
            ->assertSessionHasErrors([
                'customer_name',
                'phone',
                'project_details',
            ]);
    }

    private function createProduct(): Product
    {
        $category = Category::query()->create([
            'name' => 'Oficinas',
            'slug' => 'oficinas',
            'description' => 'Espacios de trabajo.',
            'is_featured' => true,
        ]);

        return Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Escritorio Presupuesto',
            'slug' => 'escritorio-presupuesto',
            'short_description' => 'Escritorio a medida.',
            'description' => 'Mueble de prueba para presupuestos.',
            'price' => 1000,
            'stock' => 3,
            'is_active' => true,
            'is_featured' => true,
        ]);
    }
}
