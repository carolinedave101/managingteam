<?php

namespace Tests\Feature;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestRedirectTest extends TestCase
{
    use RefreshDatabase;

    private function celebrity(): Celebrity
    {
        $admin = User::factory()->create(['role' => 'admin']);

        return Celebrity::create([
            'slug' => 'jennie',
            'name' => 'Jennie',
            'category' => 'music',
            'bio' => 'Test bio',
            'is_active' => true,
            'config' => [],
            'created_by' => $admin->id,
        ]);
    }

    public function test_unauthenticated_private_meetup_booking_redirects_to_login(): void
    {
        $this->celebrity();

        $response = $this->post('http://jennie.localhost:8000/private-meetup', [
            'title' => 'Coffee Chat',
            'date' => now()->addDays(3)->format('Y-m-d H:i'),
            'duration' => 60,
            'payment_method' => 'bank_transfer',
        ]);

        $response->assertStatus(302);
        $this->assertStringContainsString('/login', $response->headers->get('Location'));
    }

    public function test_unauthenticated_wallet_page_redirects_to_login(): void
    {
        $this->celebrity();

        $response = $this->get('http://jennie.localhost:8000/wallet');

        $response->assertStatus(302);
        $this->assertStringContainsString('/login', $response->headers->get('Location'));
    }
}
