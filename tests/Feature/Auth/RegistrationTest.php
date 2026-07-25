<?php

namespace Tests\Feature\Auth;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
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

    public function test_registration_screen_can_be_rendered_on_subdomain(): void
    {
        $response = $this->get('http://testceleb.localhost/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_on_subdomain(): void
    {
        $response = $this->post('http://testceleb.localhost/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('celebrity_fan', [
            'user_id' => auth()->id(),
            'celebrity_id' => 1,
        ]);
        $response->assertRedirect(route('celebrity.dashboard', ['celebrity' => 'testceleb']));
    }

    public function test_main_domain_register_returns_404(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(404);
    }
}
