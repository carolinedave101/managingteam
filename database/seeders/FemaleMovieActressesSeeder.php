<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FemaleMovieActressesSeeder extends Seeder
{
    private array $colorPalettes = [
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

    private array $fontPairings = [
        ['heading' => 'Playfair+Display:ital,wght@0,500;0,600;0,700', 'body' => 'Inter:wght@400;500;600'],
        ['heading' => 'Space+Grotesk:wght@500;600;700', 'body' => 'DM+Sans:ital,wght@0,400;0,500;0,700'],
        ['heading' => 'Poppins:wght@600;700;800', 'body' => 'Manrope:wght@400;500;600;700'],
        ['heading' => 'Merriweather:wght@700;900', 'body' => 'Open+Sans:wght@400;600;700'],
        ['heading' => 'Archivo+Black:wght@400', 'body' => 'Archivo:wght@400;500;600;700'],
        ['heading' => 'Oswald:wght@500;600;700', 'body' => 'Roboto:wght@400;500;700'],
        ['heading' => 'Montserrat:wght@600;700;800;900', 'body' => 'Nunito+Sans:wght@400;600;700'],
        ['heading' => 'Anton:wght@400', 'body' => 'Source+Sans+3:wght@400;600;700'],
        ['heading' => 'Bebas+Neue:wght@400', 'body' => 'Work+Sans:wght@400;500;600'],
        ['heading' => 'Cinzel:wght@500;600;700;800', 'body' => 'Cormorant+Garamond:wght@400;500;600'],
    ];

    private array $pricingTemplate = [
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

        private array $names = [
        'Marilyn Monroe', 'Audrey Hepburn', 'Katharine Hepburn', 'Bette Davis', 'Grace Kelly',
        'Ingrid Bergman', 'Elizabeth Taylor', 'Vivien Leigh', 'Marlene Dietrich', 'Greta Garbo',
        'Rita Hayworth', 'Lauren Bacall', 'Judy Garland', 'Lana Turner', 'Ava Gardner',
        'Ginger Rogers', 'Mae West', 'Betty Grable', 'Joan Crawford', 'Barbara Stanwyck',
        'Myrna Loy', 'Claudette Colbert', 'Lillian Gish', 'Olivia de Havilland', 'Joan Fontaine',
        'Carole Lombard', 'Jean Harlow', 'Norma Shearer', 'Janet Leigh', 'Gene Tierney',
        'Ann Sheridan', 'Dorothy Dandridge', 'Hedy Lamarr', 'Veronica Lake', 'Jane Fonda',
        'Faye Dunaway', 'Diane Keaton', 'Meryl Streep', 'Julie Andrews', 'Barbra Streisand',
        'Catherine Deneuve', 'Sophia Loren', 'Anjelica Huston', 'Jessica Lange', 'Goldie Hawn',
        'Sally Field', 'Ellen Burstyn', 'Glenda Jackson', 'Vanessa Redgrave', 'Maggie Smith',
        'Dyan Cannon', 'Jill Clayburgh', 'Marsha Mason', 'Lee Remick', 'Shirley MacLaine',
        'Natalie Wood', 'Julie Christie', 'Joanne Woodward', 'Patty Duke', 'Angela Lansbury',
        'Debbie Reynolds', 'Doris Day', 'Ann-Margret', 'Raquel Welch', 'Jodie Foster',
        'Susan Sarandon', 'Sigourney Weaver', 'Holly Hunter', 'Glenn Close', 'Geena Davis',
        'Michelle Pfeiffer', 'Julia Roberts', 'Sharon Stone', 'Demi Moore', 'Meg Ryan',
        'Whoopi Goldberg', 'Kathy Bates', 'Frances McDormand', 'Emma Thompson', 'Jessica Tandy',
        'Angelica Huston', 'Winona Ryder', 'Melanie Griffith', 'Kim Basinger', 'Rene Russo',
        'Mary Elizabeth Mastrantonio', 'Laura Dern', 'Diane Lane', 'Andie MacDowell', 'Patricia Arquette',
        'Sissy Spacek', 'Maryl Streep', 'Carrie Fisher', 'Michelle Yeoh', 'Tilda Swinton',
        'Helena Bonham Carter', 'Kate Winslet', 'Cate Blanchett', 'Julianne Moore', 'Nicole Kidman',
        'Judi Dench', 'Helen Mirren', 'Jennifer Lawrence', 'Scarlett Johansson', 'Jennifer Aniston',
        'Sandra Bullock', 'Angelina Jolie', 'Reese Witherspoon', 'Charlize Theron', 'Natalie Portman',
        'Anne Hathaway', 'Amy Adams', 'Emma Stone', 'Margot Robbie', 'Jessica Chastain',
        'Viola Davis', 'Lupita Nyongo', 'Saoirse Ronan', 'Brie Larson', 'Elizabeth Olsen',
        'Gal Gadot', 'Zendaya', 'Florence Pugh', 'Anya Taylor-Joy', 'Ana de Armas',
        'Megan Fox', 'Alicia Vikander', 'Rachel McAdams', 'Kate Beckinsale', 'Mila Kunis',
        'Dakota Johnson', 'Emma Watson', 'Kristen Stewart', 'Jennifer Connelly', 'Halle Berry',
        'Drew Barrymore', 'Cameron Diaz', 'Salma Hayek', 'Penelope Cruz', 'Marion Cotillard',
        'Rene Zellweger', 'Catherine Zeta-Jones', 'Naomi Watts', 'Toni Collette', 'Sophie Marceau',
        'Jessica Alba', 'Keira Knightley', 'Emily Blunt', 'Gwyneth Paltrow', 'Kirsten Dunst',
        'Kristen Bell', 'Amanda Seyfried', 'Zooey Deschanel', 'Isla Fisher', 'Ali Wong',
        'Awkwafina', 'Constance Wu', 'Gemma Chan', 'Mindy Kaling', 'Priyanka Chopra',
        'Deepika Padukone', 'Danai Gurira', 'Letitia Wright', 'Janelle Monae', 'Rashida Jones',
        'Rosario Dawson', 'Eva Longoria', 'America Ferrera', 'Gina Rodriguez', 'Melissa McCarthy',
        'Tina Fey', 'Amy Poehler', 'Kristen Wiig', 'Maya Rudolph', 'Leslie Jones',
        'Kate McKinnon', 'Aidy Bryant', 'Cecily Strong', 'Vanessa Bayer', 'Sydney Sweeney',
        'Molly Ringwald', 'Robin Wright', 'Jennifer Garner', 'Michelle Monaghan', 'Bryce Dallas Howard',
        'Alicia Keys', 'Halle Bailey', 'Storm Reid', 'Yara Shahidi', 'Marsai Martin',
        'Mckenna Grace', 'Millie Bobby Brown', 'Sadie Sink', 'Natalia Dyer', 'Maya Hawke',
        'Hunter Schafer', 'Jenna Ortega', 'Rachel Zegler', 'Angela Bassett', 'Taraji P Henson',
    ];

    public function run(): void
    {
        set_time_limit(0);

        $admin = User::firstOrCreate(
            ['email' => 'admin@managingteam.info'],
            ['name' => 'Admin', 'password' => Hash::make('admin123!'), 'role' => 'admin', 'is_verified' => true]
        );

        $created = 0;
        $skipped = 0;

        foreach ($this->names as $name) {
            $slug = Str::slug($name);

            if (Celebrity::where('slug', $slug)->exists()) {
                $this->command?->warn("Skipping {$name} — slug already exists.");
                $skipped++;
                continue;
            }

            $palette = $this->colorPalettes[array_rand($this->colorPalettes)];
            $fonts = $this->fontPairings[array_rand($this->fontPairings)];
            $themes = ['dark', 'light'];

            $config = [
                'theme' => [
                    'mode' => $themes[array_rand($themes)],
                    'primary_color' => $palette['primary'],
                    'secondary_color' => $palette['secondary'],
                    'font_heading' => $fonts['heading'],
                    'font_body' => $fonts['body'],
                ],
                'features' => [
                    'memberships' => true,
                    'meet_and_greet' => true,
                    'private_meetups' => true,
                    'membership_cards' => true,
                    'messaging' => true,
                    'wallet' => true,
                    'merch' => true,
                ],
                'payment' => [
                    'currency' => 'USD',
                    'stripe_enabled' => false,
                ],
                'seo' => [
                    'title' => "{$name} — Official Fan Community",
                    'description' => "Join the official {$name} fan portal. Memberships, meet & greet events, private meetups, and exclusive content.",
                ],
            ];
            $config = array_merge($config, $this->pricingTemplate);

            $celebrity = Celebrity::create([
                'name' => $name,
                'slug' => $slug,
                'bio' => "Official fan community for {$name}. Join the portal to connect with fellow fans, get exclusive content, and be part of the journey.",
                'category' => 'movie_star',
                'avatar' => Celebrity::avatarUrlFor($name),
                'cover_photo' => Celebrity::coverUrlFor($slug),
                'gender' => 'female',
                'country' => 'United States',
                'is_active' => true,
                'social_links' => [
                    'facebook' => null,
                    'twitter' => null,
                    'instagram' => null,
                    'youtube' => null,
                ],
                'config' => $config,
                'created_by' => $admin->id,
            ]);

            $email = $slug . '1@demo.com';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name . ' Fan',
                    'password' => Hash::make('demo1234!'),
                    'role' => 'fan',
                    'is_verified' => true,
                ]
            );

            if (! $user->celebrities()->where('celebrity_id', $celebrity->id)->exists()) {
                $user->celebrities()->attach($celebrity->id);
            }

            $created++;
        }

        $total = count($this->names);
        $this->command?->info("FemaleMovieActressesSeeder: {$created} created, {$skipped} skipped (out of {$total})");
    }
}
