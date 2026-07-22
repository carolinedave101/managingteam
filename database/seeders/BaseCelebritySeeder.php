<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BaseCelebritySeeder extends Seeder
{
    protected array $colorPalettes = [
        ['primary' => '#1e40af', 'secondary' => '#3b82f6'],
        ['primary' => '#dc2626', 'secondary' => '#f97316'],
        ['primary' => '#059669', 'secondary' => '#10b981'],
        ['primary' => '#7c3aed', 'secondary' => '#a855f7'],
        ['primary' => '#db2777', 'secondary' => '#ec4899'],
        ['primary' => '#d97706', 'secondary' => '#f59e0b'],
        ['primary' => '#0891b2', 'secondary' => '#06b6d4'],
        ['primary' => '#be123c', 'secondary' => '#e11d48'],
        ['primary' => '#4f46e5', 'secondary' => '#6366f1'],
        ['primary' => '#15803d', 'secondary' => '#22c55e'],
    ];

    protected array $pricingTemplate = [
        'membership_tiers' => [
            ['name' => 'Standard', 'price' => 3000, 'color' => '#C0C0C0', 'benefits' => ['Exclusive community access', 'Monthly newsletter', 'Digital membership card', 'Exclusive fan badge', 'Direct messaging with team']],
            ['name' => 'Premium', 'price' => 5000, 'color' => '#FFD700', 'benefits' => ['Everything in Standard', 'Early access to events', 'Priority messaging', 'Exclusive monthly content', 'Member-only livestreams', 'Priority support']],
            ['name' => 'VIP', 'price' => 10000, 'color' => '#E5E4E2', 'benefits' => ['Everything in Premium', 'Quarterly 1-on-1 video call', 'Signed merchandise', 'Private meetup invitations', 'All-access pass', 'Personalized video message', '24/7 priority support', 'Lifetime status badge']],
        ],
        'pricing' => [
            'fan_application_fee' => 5000,
            'membership_card_fee' => 5000,
            'meet_greet_default_price' => 1000,
            'private_meetup' => [
                ['duration' => 30, 'price' => 5000],
                ['duration' => 60, 'price' => 10000],
            ],
        ],
    ];

    protected function generateNames(array $firstNames, array $lastNames, int $count): array
    {
        $names = [];
        foreach ($firstNames as $first) {
            foreach ($lastNames as $last) {
                $names[] = $first.' '.$last;
            }
        }
        shuffle($names);
        return array_slice($names, 0, min($count, count($names)));
    }

    protected function createCelebrities(array $names, string $category, string $gender, string $country): int
    {
        $existingSlugs = DB::table('celebrities')->pluck('slug')->flip();

        $adminId = DB::table('users')->where('email', 'admin@managingteam.info')->value('id');
        if (!$adminId) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@managingteam.info',
                'password' => Hash::make('admin123!'),
                'role' => 'admin',
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $adminId = DB::getPdo()->lastInsertId();
        }

        $themes = ['dark', 'light'];
        $now = now();
        $chunkSize = 500;

        $entries = [];
        $created = 0;
        $skipped = 0;

        foreach ($names as $name) {
            $slug = Str::slug($name);

            if (isset($existingSlugs[$slug])) {
                $skipped++;
                continue;
            }
            $existingSlugs[$slug] = true;

            $palette = $this->colorPalettes[array_rand($this->colorPalettes)];

            $config = [
                'theme' => [
                    'mode' => $themes[array_rand($themes)],
                    'primary_color' => $palette['primary'],
                    'secondary_color' => $palette['secondary'],
                ],
                'features' => [
                    'fan_applications' => true,
                    'membership' => true,
                    'meet_greet' => true,
                    'membership_card' => true,
                    'private_meetup' => true,
                    'messaging' => true,
                ],
            ];
            $config = array_merge($config, $this->pricingTemplate);

            $entries[] = [
                'name' => $name,
                'slug' => $slug,
                'bio' => "Official fan community for {$name}. Join the portal to connect with fellow fans, get exclusive content, and be part of the journey.",
                'category' => $category,
                'avatar' => 'https://ui-avatars.com/api/?name='.urlencode($name).'&size=400&background=random&color=fff&bold=true',
                'cover_photo' => 'https://picsum.photos/seed/'.$slug.'/1200/600',
                'gender' => $gender,
                'country' => $country,
                'is_active' => true,
                'social_links' => '[]',
                'config' => json_encode($config),
                'gallery_images' => null,
                'created_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $created++;

            if (count($entries) >= $chunkSize) {
                DB::table('celebrities')->insert($entries);
                $entries = [];
            }
        }

        if (count($entries) > 0) {
            DB::table('celebrities')->insert($entries);
        }

        $this->command?->info("  {$category} {$gender}: {$created} created, {$skipped} skipped");

        return $created;
    }
}
