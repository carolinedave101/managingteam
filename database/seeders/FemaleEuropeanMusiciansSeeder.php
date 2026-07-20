<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FemaleEuropeanMusiciansSeeder extends Seeder
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
        'Adele', 'Amy Winehouse', 'Dusty Springfield', 'Annie Lennox', 'Kate Bush',
        'Florence Welch', 'Ellie Goulding', 'Dua Lipa', 'Rita Ora', 'Jessie J',
        'Leona Lewis', 'Cheryl Cole', 'Nicola Roberts', 'Nadine Coyle', 'Kimberley Walsh',
        'Sarah Harding', 'Girls Aloud Member', 'Spice Girls Member', 'Mel B', 'Mel C',
        'Emma Bunton', 'Geri Halliwell', 'Victoria Beckham', 'Siobhan Donaghy', 'Mutya Buena',
        'Keisha Buchanan', 'Heidi Range', 'Amelle Berrabah', 'Jade Ewen', 'Shaznay Lewis',
        'Natalie Appleton', 'Nicole Appleton', 'Shirley Manson', 'Lana Del Rey', 'Marina Diamandis',
        'Lily Allen', 'Kate Nash', 'Paloma Faith', 'Corinne Bailey Rae', 'Joss Stone',
        'Duffy', 'Estelle', 'Ms. Dynamite', 'M.I.A.', 'Sade Adu',
        'Lisa Stansfield', 'Des\'ree', 'Gabrielle', 'Mica Paris', 'Caron Wheeler',
        'Sinead O\'Connor', 'Enya', 'Sharon Corr', 'Andrea Corr', 'Caroline Corr',
        'Dolores O\'Riordan', 'Imelda May', 'Mary Black', 'Frances Black', 'Moya Brennan',
        'Clannad Singer', 'Róisín Murphy', 'Annie', 'Björk', 'Emilíana Torrini',
        'Of Monsters and Men Singer', 'Sigur Rós Singer', 'Laufey', 'Kylie Minogue', 'Dannii Minogue',
        'Olivia Newton-John', 'Delta Goodrem', 'Kasey Chambers', 'Sia', 'Missy Higgins',
        'Tones and I', 'Iggy Azalea', 'Neneh Cherry', 'Robyn', 'Lykke Li',
        'Tove Lo', 'Zara Larsson', 'Loreen', 'Måns Zelmerlöw\'s Wife', 'Agnes Carlsson',
        'September', 'Carola Häggkvist', 'Anni-Frid Lyngstad', 'Agnetha Fältskog', 'Helen Sjöholm',
        'Lisa Nilsson', 'Sofia Källgren', 'Sanne Salomonsen', 'Medina', 'Nabiha',
        'Aura Dione', 'Oh Land', 'Mø', 'Larsen', 'Alma',
        'Mireille Mathieu', 'Édith Piaf', 'Dalida', 'Françoise Hardy', 'Jane Birkin',
        'Brigitte Fontaine', 'Serge Gainsbourg\'s Daughter', 'Charlotte Gainsbourg', 'Vanessa Paradis', 'Carla Bruni',
        'Zaz', 'Christine and the Queens', 'Jain', 'Louane', 'Nolwenn Leroy',
        'Lara Fabian', 'Céline Dion', 'Roch Voisine\'s Partner', 'Isabelle Boulay', 'Lynda Lemay',
        'Laura Pausini', 'Mina', 'Giorgia', 'Elisa', 'Gianna Nannini',
        'Anna Oxa', 'Rita Pavone', 'Ornella Vanoni', 'Patty Pravo', 'Iva Zanicchi',
        'Mietta', 'Nek\'s Partner', 'Arisa', 'Malika Ayane', 'Noemi',
        'Emma Marrone', 'Giusy Ferreri', 'Annalisa', 'Elodie', 'Madame',
        'Raphael Gualazzi\'s Wife', 'Rosalia', 'Amaral', 'Bebe', 'Nena Daconte',
        'La Oreja de Van Gogh Singer', 'Marta Sánchez', 'Paloma San Basilio', 'Rocío Jurado', 'Isabel Pantoja',
        'Lola Flores', 'Carmen Linares', 'Estrella Morente', 'Pastora Soler', 'Mónica Naranjo',
        'Rosario Flores', 'Niña Pastori', 'Shakira\'s Backup', 'Natalia Oreiro', 'Valeria Lynch',
        'Thalía\'s Sister', 'Paulina Rubio\'s Mom', 'Nina Hagen', 'Nena', 'Lena',
        'Xavier Naidoo\'s Partner', 'Annette Humpe', 'Ideal Singer', 'Sandra', 'Kim Wilde',
        'Nikki Leonti', 'Lale Andersen', 'Marlene Dietrich', 'Zarah Leander', 'Juliane Werding',
        'Heike Makatsch\'s Singer', 'Annett Louisan', 'Lena Meyer-Landrut', 'Sasha\'s Partner', 'Stefanie Hertel',
        'Mariah Carey\'s Mother-in-Law', 'Vera Lynn', 'Dame Vera Lynn\'s Daughter', 'Cleo Laine', 'Petula Clark',
        'Shirley Bassey', 'Lulu', 'Cilla Black', 'Alma Cogan', 'Helen Shapiro',
        'Sandie Shaw', 'Dusty Springfield\'s Sister', 'Patsy Cline\'s European Cousin', 'The Seekers Singer', 'Judith Durham',
        'Marlene VerPlanck', 'Clara Butt', 'Kathleen Ferrier', 'Janet Baker', 'Dame Janet Baker\'s Successor',
        'Eva Cassidy', 'Beth Orton', 'PJ Harvey', 'Tracey Thorn', 'Alison Moyet',
        'Siouxsie Sioux', 'Poly Styrene', 'Kathleen Hanna\'s UK Counterpart', 'Kim Gordon\'s European Friend', 'Thalia Zedek',
        'Crystal Waters', 'Robin S.', 'CeCe Peniston\'s UK Sister', 'Lisa Lashes', 'Anne Clark',
        'Kate West', 'Enya\'s Sister', 'Moya Brennan\'s Daughter', 'Cara Dillon', 'Kathryn Tickell',
        'June Tabor', 'Sandy Denny', 'Maddy Prior', 'Jacqui McShee', 'Linda Thompson',
        'Angelo Badalamenti\'s Singer', 'Lhasa de Sela', 'Susheela Raman', 'Najma Akhtar', 'Sheila Chandra',
        'Misty In Roots', 'Carroll Thompson', 'Janet Kay', 'Beverley Craven', 'Julia Fordham',
        'Katherine Jenkins', 'Hayley Westenra', 'Charlotte Church', 'Sarah Brightman', 'Lesley Garrett',
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
                'gender' => 'female',
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
        $this->command?->info("FemaleEuropeanMusiciansSeeder: {$created} created, {$skipped} skipped (out of {$total})");
    }
}
