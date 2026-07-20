<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MaleEuropeanActorsSeeder extends Seeder
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
        'Laurence Olivier', 'Ian McKellen', 'Patrick Stewart', 'Daniel Day-Lewis', 'Gary Oldman',
        'Ralph Fiennes', 'Liam Neeson', 'Pierce Brosnan', 'Colin Firth', 'Hugh Grant',
        'Tom Hiddleston', 'Benedict Cumberbatch', 'Eddie Redmayne', 'Tom Hardy', 'Idris Elba',
        'Chiwetel Ejiofor', 'Christian Bale', 'Michael Caine', 'Sean Connery', 'Ewan McGregor',
        'James McAvoy', 'David Tennant', 'Matt Smith', 'Peter Capaldi', 'John Hurt',
        'Alan Rickman', 'Richard Harris', 'Peter O\'Toole', 'Albert Finney', 'Tom Courtenay',
        'Terence Stamp', 'Michael Gambon', 'Maggie Smith\'s Husband', 'Kenneth Branagh', 'Judi Dench\'s Partner',
        'Daniel Craig', 'Roger Moore', 'Timothy Dalton', 'George Lazenby', 'David Niven',
        'Jean Reno', 'Gérard Depardieu', 'Vincent Cassel', 'Omar Sy', 'Alain Delon',
        'Jean-Paul Belmondo', 'Louis de Funès', 'Fernandel', 'Yves Montand', 'Philippe Noiret',
        'Javier Bardem', 'Antonio Banderas', 'Penélope Cruz\'s Husband', 'Fernando Rey', 'Paco Rabal',
        'Marcello Mastroianni', 'Roberto Benigni', 'Vittorio Gassman', 'Adriano Celentano', 'Alberto Sordi',
        'Nino Manfredi', 'Toto', 'Giancarlo Giannini', 'Massimo Troisi', 'Michele Placido',
        'Mads Mikkelsen', 'Nikolaj Coster-Waldau', 'Viggo Mortensen', 'Max von Sydow', 'Stellan Skarsgård',
        'Alexander Skarsgård', 'Bill Skarsgård', 'Gustaf Skarsgård', 'Peter Stormare', 'Dolph Lundgren',
        'Daniel Brühl', 'Diane Kruger\'s Partner', 'Michael Fassbender', 'Christoph Waltz', 'Klaus Kinski',
        'Werner Herzog', 'Bruno Ganz', 'Uwe Ochsenknecht', 'Heiner Lauterbach', 'Mario Adorf',
        'Claudio Brook', 'Kazimierz Wajda', 'Andrzej Wajda', 'Zbigniew Cybulski', 'Daniel Olbrychski',
        'Jerzy Stuhr', 'Marek Kondrat', 'Bogusław Linda', 'Cezary Pazura', 'Jan Nowicki',
        'Karel Roden', 'Jirí Menzel', 'Vlastimil Bedrna', 'Rudolf Hrusínský', 'Vladimír Mensík',
        'Jaan Tätte', 'Lembit Ulfsak', 'Argo Aadli', 'Tambet Tuisk', 'Mait Malmsten',
        'Rade Šerbedžija', 'Goran Višnjić', 'Branko Durić', 'Miki Manojlović', 'Lazar Ristovski',
        'Willem Dafoe', 'Rutger Hauer', 'Jeroen Krabbé', 'Derek de Lint', 'Huub Stapel',
        'Jan Decleir', 'Matthias Schoenaerts', 'Koen De Bouw', 'Tom Van Landuyt', 'Axel Daeseleire',
        'Joaquim de Almeida', 'Diogo Infante', 'Rui Morrison', 'Nuno Lopes', 'José Pedro Gomes',
        'Alexandros Kouris', 'Nikos Kourkoulos', 'Giorgos Foundas', 'Dimitris Papamichael', 'Vladimiros Kyriakidis',
        'Tchéky Karyo', 'Alain Delon\'s Son', 'Lambert Wilson', 'Mathieu Amalric', 'François Cluzet',
        'Gilles Lellouche', 'Benoît Magimel', 'Romain Duris', 'Vincent Lindon', 'Pio Marmaï',
        'Franco Nero', 'Claudio Gora', 'Ugo Tognazzi', 'Marcel Proust', 'Lino Ventura',
        'Sergio Castellitto', 'Kim Rossi Stuart', 'Elio Germano', 'Toni Servillo', 'Valerio Mastandrea',
        'Vangelis Katsoulis', 'Christos Stylianou', 'Michalis Violaris', 'Marios Ioannou', 'Kostas Voutsas',
        'Josef Abrhám', 'Oldrich Kaiser', 'Jirí Kodl', 'Vlastimil Harapes', 'Pavel Landovský',
        'Antanas Šurna', 'Regimantas Adomaitis', 'Donatas Banionis', 'Juozas Budraitis', 'Bronius Babkauskas',
        'Byron Browne', 'Robert Carlyle', 'Brian Cox', 'Sean Bean', 'Tom Conti',
        'Stephen Fry', 'Hugh Laurie', 'Rowan Atkinson', 'John Cleese', 'Eric Idle',
        'Michael Palin', 'Terry Jones', 'Terry Gilliam', 'Graham Chapman', 'John Smith',
        'Richard E. Grant', 'Simon Pegg', 'Nick Frost', 'Bill Nighy', 'Rhys Ifans',
        'John Rhys-Davies', 'Anthony Hopkins', 'Jonathan Pryce', 'Timothy Spall', 'Jim Broadbent',
        'David Morrissey', 'Christopher Eccleston', 'Paul Bettany', 'Andy Serkis', 'Martin Freeman',
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
        $this->command?->info("MaleEuropeanActorsSeeder: {$created} created, {$skipped} skipped (out of {$total})");
    }
}
