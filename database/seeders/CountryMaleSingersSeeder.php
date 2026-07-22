<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CountryMaleSingersSeeder extends Seeder
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
        // — Legends / Pioneers (pre-1980s) —
        'Hank Williams', 'Johnny Cash', 'Willie Nelson', 'Waylon Jennings', 'Merle Haggard',
        'George Jones', 'Conway Twitty', 'Charley Pride', 'Buck Owens', 'Porter Wagoner',
        'Don Williams', 'Roger Miller', 'Marty Robbins', 'Faron Young', 'Ray Price',
        'Ernest Tubb', 'Lefty Frizzell', 'Hank Snow', 'Jim Reeves', 'Eddy Arnold',
        'Gene Autry', 'Roy Rogers', 'Tex Ritter', 'Red Foley', 'Carl Smith',
        'Webb Pierce', 'Jerry Reed', 'Charlie Daniels', 'Tom T. Hall', 'Bobby Bare',
        'John Denver', 'Glen Campbell', 'Kenny Rogers', 'Don Gibson', 'Bill Monroe',
        'Lester Flatt', 'Earl Scruggs', 'Ricky Skaggs', 'Kris Kristofferson', 'Johnny Rodriguez',

        // — 80s/90s Icons —
        'Randy Travis', 'George Strait', 'Alan Jackson', 'Clint Black', 'Vince Gill',
        'Garth Brooks', 'Ronnie Dunn', 'Kix Brooks', 'Toby Keith', 'Tim McGraw',
        'Kenny Chesney', 'Brad Paisley', 'Dwight Yoakam', 'Lyle Lovett', 'Steve Earle',
        'Travis Tritt', 'Marty Stuart', 'Joe Diffie', 'John Michael Montgomery', 'Collin Raye',
        'Aaron Tippin', 'Mark Chesnutt', 'Tracy Lawrence', 'Neal McCoy', 'Wade Hayes',

        // — Additional 90s —
        'Ricky Van Shelton', 'Keith Whitley', 'Earl Thomas Conley', 'John Anderson', 'Lee Greenwood',
        'T.G. Sheppard', 'Moe Bandy', 'Gene Watson', 'Vern Gosdin', 'Mel Tillis',
        'Freddie Hart', 'Johnny Paycheck', 'David Allan Coe', 'Billy Joe Shaver', 'Townes Van Zandt',
        'Guy Clark', 'Jerry Jeff Walker', 'Michael Martin Murphey', 'Larry Gatlin', 'Hank Williams Jr.',

        // — 2000s Mainstream —
        'Blake Shelton', 'Keith Urban', 'Jason Aldean', 'Luke Bryan', 'Eric Church',
        'Dierks Bentley', 'Chris Stapleton', 'Joe Nichols', 'Josh Turner', 'Chris Young',
        'Billy Currington', 'Craig Morgan', 'Trace Adkins', 'Gary Allan', 'Rodney Atkins',
        'Chris Cagle', 'Pat Green', 'Jack Ingram', 'Darius Rucker', 'Big Kenny',
        'John Rich', 'Jake Owen', 'Brett Eldredge', 'Thomas Rhett', 'Luke Combs',
        'Morgan Wallen', 'Cody Johnson', 'Jon Pardi', 'Kane Brown', 'Bailey Zimmerman',
        'Jelly Roll', 'HARDY', 'Riley Green', 'Russell Dickerson', 'Jordan Davis',
        'Dylan Scott', 'Mitchell Tenpenny', 'Walker Hayes', 'Michael Ray', 'Brett Young',

        // — 2000s/2010s —
        'Dan Smyers', 'Shay Mooney', 'Chase Rice', 'Lee Brice', 'Kip Moore',
        'Brantley Gilbert', 'Justin Moore', 'Randy Houser', 'Chris Janson', 'Jerrod Niemann',
        'David Nail', 'Tyler Farr', 'Easton Corbin', 'Scotty McCreery', 'Hunter Hayes',
        'Frankie Ballard', 'Dustin Lynch', 'Granger Smith', 'Chase Bryant', 'Mark Wills',
        'Andy Griggs', 'Phil Vassar', 'Eddie Montgomery', 'Troy Gentry', 'David Lee Murphy',
        'Chris LeDoux', 'Aaron Lewis', 'Jamey Johnson', 'Sturgill Simpson', 'Tyler Childers',

        // — 2010s/2020s New Wave —
        'Zach Bryan', 'Colter Wall', 'Jason Isbell', 'Ryan Adams', 'Cody Jinks',
        'Parker McCollum', 'Koe Wetzel', 'Kolby Cooper', 'Jackson Dean', 'Chayce Beckham',
        'Warren Zeiders', 'Nate Smith', 'Corey Kent', 'Larry Fleet', 'Dillon Carmichael',
        'Matt Stell', 'Travis Denning', 'Jameson Rodgers', 'Ryan Griffin', 'Adam Doleac',

        // — Texas / Red Dirt —
        'Robert Earl Keen', 'Cory Morrow', 'Kevin Fowler', 'Wade Bowen', 'Randy Rogers',
        'Casey Donahew', 'Aaron Watson', 'Josh Abbott', 'William Clark Green', 'Mike Ryan',
        'Stoney LaRue', 'Micky Braun', 'Willy Braun', 'Cody Canada', 'Sam Cole',
        'Jason Boland', 'Chris Knight', 'Slaid Cleaves', 'James McMurtry', 'Todd Snider',

        // — More Contemporary / Singer-Songwriters —
        'Hayes Carll', 'Brent Cobb', 'Charley Crockett', 'Vincent Neil Emerson', 'Zach Top',
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
                'gender' => 'male',
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

            $email = $slug.'1@demo.com';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name.' Fan',
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
        $this->command?->info("CountryMaleSingersSeeder: {$created} created, {$skipped} skipped (out of {$total})");
    }
}
