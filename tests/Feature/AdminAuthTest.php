<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_login_and_logout(): void
    {
        $user = User::query()->create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);

        $this->post(route('admin.logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
