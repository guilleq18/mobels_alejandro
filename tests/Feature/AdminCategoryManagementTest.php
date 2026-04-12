<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_category(): void
    {
        $this->actingAs($this->adminUser())
            ->post(route('admin.categories.store'), [
                'name' => 'Cocinas Integrales',
                'slug' => '',
                'description' => 'Muebles de cocina completos.',
                'is_featured' => '1',
            ])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Cocinas Integrales',
            'slug' => 'cocinas-integrales',
            'is_featured' => true,
        ]);
    }

    public function test_admin_cannot_delete_a_category_that_has_products(): void
    {
        $category = Category::query()->create([
            'name' => 'Dormitorios',
            'slug' => 'dormitorios',
            'description' => 'Linea dormitorio.',
            'is_featured' => true,
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Placard Base',
            'slug' => 'placard-base',
            'short_description' => 'Placard demo.',
            'description' => 'Producto para bloqueo.',
            'price' => 1000,
            'stock' => 2,
            'is_active' => true,
            'is_featured' => false,
        ]);

        $this->actingAs($this->adminUser())
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'slug' => 'dormitorios',
        ]);
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
