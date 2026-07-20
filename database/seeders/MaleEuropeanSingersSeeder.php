<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MaleEuropeanSingersSeeder extends Seeder
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

    private array $names = [
        'Ed Sheeran', 'Elton John', 'Paul McCartney', 'John Lennon', 'George Harrison',
        'Ringo Starr', 'Freddie Mercury', 'David Bowie', 'Mick Jagger', 'Keith Richards',
        'Eric Clapton', 'Sting', 'Phil Collins', 'Peter Gabriel', 'Robert Plant',
        'Jimmy Page', 'Roger Waters', 'David Gilmour', 'Nick Mason', 'Richard Wright',
        'Bono', 'The Edge', 'Adam Clayton', 'Larry Mullen Jr.', 'Van Morrison',
        'Tom Jones', 'Rod Stewart', 'Billy Idol', 'Boy George', 'George Michael',
        'Robbie Williams', 'Harry Styles', 'Louis Tomlinson', 'Zayn Malik', 'Liam Payne',
        'Niall Horan', 'Sam Smith', 'Adele\'s Partner', 'James Bay', 'Tom Grennan',
        'Lewis Capaldi', 'Olly Murs', 'Eddie Vedder', 'Bruce Springsteen', 'Bob Dylan',
        'Leonard Cohen', 'Neil Young', 'Gordon Lightfoot', 'Ian Gillan', 'Ozzy Osbourne',
        'Tony Iommi', 'Ronnie James Dio', 'Bruce Dickinson', 'Steve Harris', 'Adrian Smith',
        'Dave Murray', 'Nicko McBrain', 'Janick Gers', 'Lemmy Kilmister', 'Phil Anselmo',
        'James Hetfield', 'Lars Ulrich', 'Kirk Hammett', 'Robert Trujillo', 'Dave Mustaine',
        'Tommy Lee', 'Vince Neil', 'Nikki Sixx', 'Mick Mars', 'Axl Rose',
        'Slash', 'Duff McKagan', 'Izzy Stradlin', 'Steven Tyler', 'Joe Perry',
        'Jon Bon Jovi', 'Richie Sambora', 'Bret Michaels', 'CC DeVille', 'Bobby Dall',
        'Rikki Rocket', 'Alice Cooper', 'Gene Simmons', 'Paul Stanley', 'Ace Frehley',
        'Peter Criss', 'David Coverdale', 'Whitesnake', 'Brian Johnson', 'Angus Young',
        'Malcolm Young', 'Bon Scott', 'Cliff Williams', 'Brian May', 'Roger Taylor',
        'John Deacon', 'Jeff Lynne', 'Roy Orbison', 'Tom Petty', 'Bob Seger',
        'John Fogerty', 'Don Henley', 'Glenn Frey', 'Joe Walsh', 'Timothy B. Schmit',
        'Lindsey Buckingham', 'Stevie Nicks', 'Mick Fleetwood', 'John McVie', 'Christine McVie\'s Husband',
        'Mark Knopfler', 'John Illsley', 'Nick Mason\'s Brother', 'Pete Townshend', 'Roger Daltrey',
        'John Entwistle', 'Daltrey\'s Son', 'Jimmy Kimmel', 'Noel Gallagher', 'Liam Gallagher',
        'Bonehead', 'Andy Bell', 'Gem Archer', 'Ray Davies', 'Dave Davies',
        'Chrissie Hynde\'s Partner', 'Johnny Marr', 'Morrissey', 'Andy Rourke', 'Mike Joyce',
        'Ian Brown', 'John Squire', 'Mani', 'Reni', 'Shaun Ryder',
        'Bez', 'Paul Weller', 'Paul Heaton', 'David Gray', 'Daniel Bedingfield',
        'Will Young', 'Gareth Gates', 'Declan McKenna', 'Sam Fender', 'Yungblud',
        'Björn Ulvaeus', 'Benny Andersson', 'Agnetha Fältskog\'s Husband', 'Anni-Frid Lyngstad\'s Partner', 'Måns Zelmerlöw',
        'Loreen\'s Producer', 'Avicii', 'Swedish House Mafia', 'Axwell', 'Sebastian Ingrosso',
        'Steve Angello', 'Alesso', 'Kygo', 'Alan Walker', 'Sigrid\'s Brother',
        'Kurt Nilsen', 'Alexander Rybak', 'Margaret Berger\'s Producer', 'Wardruna\'s Singer', 'Morten Harket',
        'Magne Furuholmen', 'Pål Waaktaar', 'Enrique Iglesias', 'Julio Iglesias', 'Alejandro Sanz',
        'Pablo Alborán', 'David Bisbal', 'Antonio Orozco', 'Miguel Bosé', 'Raphael',
        'Eros Ramazzotti', 'Andrea Bocelli', 'Zucchero', 'Adriano Celentano\'s Son', 'Tiziano Ferro',
        'Ligabue', 'Jovanotti', 'Vasco Rossi', 'Fabri Fibra', 'Michele Bravi',
        'Herbert Grönemeyer', 'Xavier Naidoo', 'Peter Maffay', 'Udo Lindenberg', 'Marius Müller-Westernhagen',
        'Nena\'s Producer', 'Falco', 'Seiler und Speer\'s Singer', 'Die Toten Hosen\'s Singer', 'Wolfgang Niedecken',
        'Charles Aznavour', 'Édith Piaf\'s Lover', 'Jacques Brel', 'Serge Gainsbourg', 'Johnny Hallyday',
        'Alain Souchon', 'Laurent Voulzy', 'Francis Cabrel', 'Renaud', 'Michel Sardou',
        'Boris Vian', 'Georges Brassens', 'Léo Ferré', 'Jacques Dutronc', 'Salvatore Adamo',
        'Marco Mengoni', 'Mahmood', 'Gianni Morandi', 'Lucio Battisti', 'Fabrizio De André',
        'Francesco De Gregori', 'Antonio Venditti', 'Rino Gaetano', 'Pino Daniele', 'Lucio Dalla',
    ];

    public function run(): void
    {
        set_time_limit(0);

        $admin = User::firstOrCreate(
            ['email' => 'admin@managingteam.info'],
            ['name' => 'Admin', 'password' => Hash::make('admin123!'), 'role' => 'admin', 'is_verified' => true]
        );

        $pricingTemplate = [
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
            $themes = ['dark', 'light'];

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
            $config = array_merge($config, $pricingTemplate);

            $celebrity = Celebrity::create([
                'name' => $name,
                'slug' => $slug,
                'bio' => "Official fan community for {$name}. Join the portal to connect with fellow fans, get exclusive content, and be part of the journey.",
                'category' => 'musician',
                'avatar' => Celebrity::avatarUrlFor($name),
                'cover_photo' => Celebrity::coverUrlFor($slug),
                'gender' => 'male',
                'country' => 'United Kingdom',
                'is_active' => true,
                'social_links' => [],
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
        $this->command?->info("MaleEuropeanSingersSeeder: {$created} created, {$skipped} skipped (out of {$total})");
    }
}
