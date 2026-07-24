<?php

namespace Tests\Feature;

use App\Models\Celebrity;
use App\Models\Giveaway;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GiveawayEnterTest extends TestCase
{
    use RefreshDatabase;

    public function test_giveaway_enter_with_free_entry(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $celebrity = Celebrity::create([
            'slug' => 'jennie',
            'name' => 'Jennie',
            'category' => 'music',
            'bio' => 'Test bio',
            'is_active' => true,
            'config' => [],
            'created_by' => $admin->id,
        ]);

        $giveaway = Giveaway::create([
            'celebrity_id' => $celebrity->id,
            'title' => 'Test Giveaway',
            'description' => 'Test description',
            'prize_description' => 'Test prize',
            'entry_fee' => 0,
            'max_entries_per_fan' => 1,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
            'is_active' => true,
            'status' => 'active',
        ]);

        $user = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($user)
            ->post('http://jennie.localhost:8000/giveaways/'.$giveaway->id.'/enter', [
                'payment_method' => 'free',
            ]);

        $response->assertStatus(302);
    }

    public function test_giveaway_enter_with_heartfelt_note(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $celebrity = Celebrity::create([
            'slug' => 'jennie',
            'name' => 'Jennie',
            'category' => 'music',
            'bio' => 'Test bio',
            'is_active' => true,
            'config' => [],
            'created_by' => $admin->id,
        ]);

        $giveaway = Giveaway::create([
            'celebrity_id' => $celebrity->id,
            'title' => 'Test Giveaway',
            'description' => 'Test description',
            'prize_description' => 'Test prize',
            'entry_fee' => 0,
            'max_entries_per_fan' => 1,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
            'is_active' => true,
            'status' => 'active',
        ]);

        $user = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($user)
            ->post('http://jennie.localhost:8000/giveaways/'.$giveaway->id.'/enter', [
                'payment_method' => 'free',
                'heartfelt_note' => 'I love Jennie because she inspires me every day! Winning this would mean so much to me.',
            ]);

        $response->assertStatus(302);

        $entry = $giveaway->entries()->where('user_id', $user->id)->first();
        $this->assertNotNull($entry);
        $this->assertEquals('I love Jennie because she inspires me every day! Winning this would mean so much to me.', $entry->heartfelt_note);
        $this->assertEquals('I love Jennie because she inspires me every day! Winning this would mean so much to me.', $entry->heartfelt_note);
    }
}
