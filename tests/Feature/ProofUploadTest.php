<?php

namespace Tests\Feature;

use App\Models\Celebrity;
use App\Models\PrivateMeetup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProofUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_private_meetup_booking_stores_uploaded_payment_proof(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $fan = User::factory()->create();

        $celebrity = Celebrity::create([
            'slug' => 'jennie',
            'name' => 'Jennie',
            'category' => 'music',
            'bio' => 'Test bio',
            'is_active' => true,
            'config' => [
                'pricing' => [
                    'private_meetup_mode' => 'duration',
                    'private_meetup' => [
                        ['duration' => 30, 'price' => 5000],
                        ['duration' => 60, 'price' => 10000],
                    ],
                ],
            ],
            'created_by' => $admin->id,
        ]);
        $celebrity->fans()->attach($fan->id);

        $response = $this->actingAs($fan)->post('http://jennie.localhost:8000/private-meetup', [
            'title' => 'Coffee Chat',
            'date' => now()->addDays(3)->format('Y-m-d H:i'),
            'duration' => 60,
            'location' => 'Seoul',
            'payment_method' => 'bank_transfer',
            'payment_proof' => UploadedFile::fake()->image('receipt.jpg'),
        ]);

        $response->assertStatus(302);

        $meetup = PrivateMeetup::where('user_id', $fan->id)->first();
        $this->assertNotNull($meetup);
        $this->assertEquals(10000, $meetup->price);
        $this->assertStringStartsWith('proofs/', $meetup->payment_proof);
        Storage::disk('public')->assertExists($meetup->payment_proof);
    }
}
