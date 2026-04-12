<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminQuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_quote_requests_in_the_panel(): void
    {
        $category = Category::query()->create([
            'name' => 'Cocinas',
            'slug' => 'cocinas',
            'description' => 'Linea cocina.',
            'is_featured' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Cocina Delta',
            'slug' => 'cocina-delta',
            'short_description' => 'Cocina demo.',
            'description' => 'Producto para pruebas admin.',
            'price' => 2500,
            'stock' => 2,
            'is_active' => true,
            'is_featured' => true,
        ]);

        $product->quoteRequests()->create([
            'customer_name' => 'Maria Gomez',
            'phone' => '3834 555555',
            'email' => 'maria@example.com',
            'city' => 'Valle Viejo',
            'project_details' => 'Necesito presupuesto con variante en color madera clara.',
            'status' => 'pending',
        ]);

        $this->actingAs($this->adminUser())
            ->get(route('admin.quote-requests.index'))
            ->assertOk()
            ->assertSee('Maria Gomez')
            ->assertSee('Cocina Delta')
            ->assertSee('Valle Viejo');
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
