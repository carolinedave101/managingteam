<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FemaleCountrySingersSeeder extends Seeder
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
        'Patsy Cline', 'Loretta Lynn', 'Dolly Parton', 'Tammy Wynette', 'Kitty Wells',
        'June Carter Cash', 'Brenda Lee', 'Connie Smith', 'Jean Shepard', 'Skeeter Davis',
        'Rose Maddox', 'Lynn Anderson', 'Jeannie C Riley', 'Bobbie Gentry', 'Wanda Jackson',
        'Crystal Gayle', 'Emmylou Harris', 'Linda Ronstadt', 'Anne Murray', 'Tanya Tucker',
        'Barbara Mandrell', 'Reba McEntire', 'The Judds', 'Kathy Mattea', 'K T Oslin',
        'Pam Tillis', 'Lorrie Morgan', 'Patty Loveless', 'Trisha Yearwood', 'Faith Hill',
        'Shania Twain', 'Martina McBride', 'Lee Ann Womack', 'Jo Dee Messina', 'Deana Carter',
        'Terri Clark', 'Mindy McCready', 'Lila McCann', 'Jessica Andrews', 'Carrie Underwood',
        'Miranda Lambert', 'Gretchen Wilson', 'Kellie Pickler', 'Taylor Swift', 'Kacey Musgraves',
        'Maren Morris', 'Kelsea Ballerini', 'Maddie Tae', 'RaeLynn', 'Cam',
        'Jana Kramer', 'Sarah Evans', 'Sara Evans', 'Ashley Monroe', 'Angaleena Presley',
        'Brandy Clark', 'Jennifer Nettles', 'Sonia Leigh', 'Elizabeth Cook', 'Nikki Lane',
        'Lindi Ortega', 'Rhiannon Giddens', 'Sierra Hull', 'Alison Krauss', 'Mary Chapin Carpenter',
        'Shawn Colvin', 'Roseanne Cash', 'Shelby Lynne', 'Allison Moorer', 'Stephanie Quayle',
        'Mickey Guyton', 'Brittney Spencer', 'Rissi Palmer', 'Camille Parker', 'Tiera Kennedy',
        'Madeline Edwards', 'Julie Roberts', 'Heidi Newfield', 'Lainey Wilson', 'Megan Moroney',
        'Bailey Zimmerman', 'Ashley Cooke', 'Lauren Alaina', 'Gabby Barrett', 'Tenille Townes',
        'Carly Pearce', 'Ingrid Andress', 'Hailey Whitters', 'Maggie Rogers', 'Lydia Loveless',
        'Courtney Marie Andrews', 'Molly Tuttle', 'Caitlyn Smith', 'Amanda Shires', 'Natalie Hemby',
        'Hillary Lindsey', 'Ryan Hurd', 'Sasha Colby', 'Sasha McEvenue', 'Gracie Abrams',
        'Maggie Lindemann', 'Brittany Howard', 'Yola', 'Alyssa Bonagura', 'Gemma Hayes',
        'Angela Easterling', 'Jamie Lin Wilson', 'Whitney Rose', 'Liz Cooper', 'Erin Rae',
        'Sierra Ferrell', 'Emily Scott Robinson', 'Miko Marks', 'Joy Oladokun', 'Katie Pruitt',
        'Sarah Shook', 'Gillian Welch', 'Iris DeMent', 'Lucinda Williams', 'Neko Case',
        'Kathleen Edwards', 'Laurie Lewis', 'Claire Lynch', 'Lynn Morris', 'Missy Raines',
        'Becky Buller', 'Sally Van Meter', 'Maura O Connell', 'Cindy Cashdollar', 'Alison Brown',
        'Darol Anger', 'K.D. Lang', 'Carolyn Dawn Johnson', 'Serena Ryder', 'Meghan Patrick',
        'Tenille Arts', 'Madeline Merlo', 'Jess Moskalake', 'Sacha', 'Kira Isabella',
        'Autumn Hill', 'Kayliann Lowe', 'Amanda Rheaume', 'Del Barber', 'Lori Yates',
        'Jill Barber', 'Catherine Durand', 'Julie Corrigan', 'Suzie Ungerleider', 'Lynn Miles',
        'Rose Cousins', 'Jenn Grant', 'Mo Kenney', 'David Myles', 'Amanda Jackson',
        'Kimberly Dunn', 'Ella Langley', 'Tigirlily Gold', 'Dylan Marlowe', 'Ashley McBryde',
        'Lindsay Ell', 'Elvie Shane', 'Caylee Hammack', 'Priscilla Block', 'Laci Kaye Booth',
        'Kalie Shorr', 'Makenzie Thomas', 'Perla Brown', 'Alexa Villa', 'Lily Meola',
        'Valerie June', 'Reyna Roberts', 'Janie Fricke', 'Marie Osmond', 'Juice Newton',
        'Charly McClain', 'Sylvia', 'Holly Dunn', 'Michelle Wright', 'Lisa Brokop',
        'Debby Boone', 'Jeannie Seely', 'Norma Jean', 'Liz Anderson', 'Susan Raye',
        'Diana Trask', 'Judy Rodman', 'Lynda K Walker', 'T Graham Brown', 'Eileen Jewell',
        'Cindy Walker', 'Megan McAllister', 'Clare Dunn', 'Emily Ann Roberts', 'Zoe Brown',
        'Payton Smith', 'Mackenzie Porter', 'Olivia Lane', 'Alee', 'Kylee Phillips',
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
                'category' => 'country_singer',
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
        $this->command?->info("FemaleCountrySingersSeeder: {$created} created, {$skipped} skipped (out of {$total})");
    }
}
