<?php

namespace Tests\Feature\Auth;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::factory()->create(['role' => 'admin']);

        Celebrity::create([
            'name' => 'Test Celebrity',
            'slug' => 'testceleb',
            'is_active' => true,
            'category' => 'musician',
            'created_by' => $admin->id,
            'config' => [
                'theme' => [
                    'primary_color' => '#ec4899',
                    'secondary_color' => '#8b5cf6',
                ],
                'site_content' => [
                    'hero_title' => 'Test Hero',
                    'hero_subtitle' => 'Test Subtitle',
                ],
                'features' => [],
                'membership_tiers' => [],
                'pricing' => [],
            ],
        ]);
    }

    public function test_login_screen_can_be_rendered_on_subdomain(): void
    {
        $response = $this->get('http://testceleb.localhost/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('http://testceleb.localhost/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('celebrity.dashboard', ['celebrity' => 'testceleb']));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('http://testceleb.localhost/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_main_domain_login_returns_404(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(404);
    }

    public function test_main_domain_register_returns_404(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(404);
    }
}
