<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FemaleEuropeanActressesSeeder extends Seeder
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
        'Dame Judi Dench', 'Helen Mirren', 'Maggie Smith', 'Vanessa Redgrave', 'Emma Thompson',
        'Kate Winslet', 'Keira Knightley', 'Emily Watson', 'Kristin Scott Thomas', 'Charlotte Rampling',
        'Julie Andrews', 'Audrey Hepburn', 'Vivien Leigh', 'Elizabeth Taylor', 'Diana Rigg',
        'Julie Christie', 'Glenda Jackson', 'Rachel Weisz', 'Kate Beckinsale', 'Rosamund Pike',
        'Carey Mulligan', 'Sienna Miller', 'Gemma Arterton', 'Emily Blunt', 'Rebecca Hall',
        'Felicity Jones', 'Lily James', 'Florence Pugh', 'Emma Corrin', 'Jodie Comer',
        'Sophie Turner', 'Emilia Clarke', 'Lena Headey', 'Maisie Williams', 'Natalie Dormer',
        'Catherine Zeta-Jones', 'Saoirse Ronan', 'Jessie Buckley', 'Ruth Wilson', 'Hayley Atwell',
        'Catherine Deneuve', 'Isabelle Huppert', 'Marion Cotillard', 'Juliette Binoche', 'Audrey Tautou',
        'Sophie Marceau', 'Emmanuelle Béart', 'Carole Bouquet', 'Fanny Ardant', 'Isabelle Adjani',
        'Léa Seydoux', 'Adèle Exarchopoulos', 'Mélanie Laurent', 'Virginie Ledoyen', 'Laetitia Casta',
        'Clémence Poésy', 'Eva Green', 'Bérénice Bejo', 'Cécile de France', 'Sylvie Testud',
        'Penélope Cruz', 'Paz Vega', 'María Valverde', 'Leonor Watling', 'Adriana Ugarte',
        'Blanca Suárez', 'Marta Etura', 'Aitana Sánchez-Gijón', 'Carmen Maura', 'Marisa Paredes',
        'Victoria Abril', 'Rossy de Palma', 'Nieves Fernández', 'Claudia Cardinale', 'Monica Bellucci',
        'Sophia Loren', 'Gina Lollobrigida', 'Anna Magnani', 'Isabella Rossellini', 'Valeria Golino',
        'Margherita Buy', 'Asia Argento', 'Sabrina Ferilli', 'Laura Morante', 'Micaela Ramazzotti',
        'Alba Rohrwacher', 'Diane Fleri', 'Kasia Smutniak', 'Francesca Neri', 'Licia Maglietta',
        'Claudia Gerini', 'Alessandra Mastronardi', 'Matilde Gioli', 'Greta Scarano', 'Maya Sansa',
        'Liv Ullmann', 'Ingrid Bergman', 'Alicia Vikander', 'Noomi Rapace', 'Greta Garbo',
        'Lena Endre', 'Pernilla August', 'Stina Ekblad', 'Malin Buska', 'Tuva Novotny',
        'Trine Dyrholm', 'Sidse Babett Knudsen', 'Paprika Steen', 'Bodil Jørgensen', 'Sonja Richter',
        'Danica Curcic', 'Clara Rugaard', 'Vigga Bro', 'Ghita Nørby', 'Ann Eleonora Jørgensen',
        'Iben Hjejle', 'Sonia Suhl', 'Nina Christensen', 'Helle Fagralid', 'Stine Stengade',
        'Hanna Schygulla', 'Nina Hoss', 'Sibel Kekilli', 'Diane Kruger', 'Franka Potente',
        'Martina Gedeck', 'Caroline Peters', 'Ulrike Folkerts', 'Désirée Nosbusch', 'Jessica Schwarz',
        'Julia Jentsch', 'Alexandra Maria Lara', 'Heike Makatsch', 'Nastassja Kinski', 'Barbara Sukowa',
        'Katarzyna Figura', 'Maja Ostaszewska', 'Agnieszka Grochowska', 'Magdalena Cielecka', 'Kinga Preis',
        'Joanna Kulig', 'Alicja Bachleda-Curuś', 'Krystyna Janda', 'Grażyna Szapołowska', 'Beata Tyszkiewicz',
        'Irena Kwiatkowska', 'Kalina Jędrusik', 'Anna Dymna', 'Ewa Wiśniewska', 'Polly Walker',
        'Anita Ekberg', 'Bibi Andersson', 'Harriet Andersson', 'Gunnar Björnstrand\'s Wife', 'May Brit Nilsson',
        'Svetlana Khodchenkova', 'Olga Kurylenko', 'Milla Jovovich', 'Oksana Akinshina', 'Chulpan Khamatova',
        'Yuliya Snigir', 'Anna Chipovskaya', 'Svetlana Ivanova', 'Ravshana Kurkova', 'Irina Starshenbaum',
        'Mateja Koležnik', 'Mirjam Korbar', 'Nataša Ninković', 'Marija Škaričić', 'Ksenija Marinković',
        'Danijela Dimitrovska', 'Ivana Roščić', 'Dolores Lambaša', 'Barbara Prpić', 'Tea Puharić',
        'Catherine Walker', 'Maryam d\'Abo', 'Samantha Morton', 'Sally Hawkins', 'Lindsay Duncan',
        'Eileen Atkins', 'Anna Massey', 'Harriet Walter', 'Gemma Jones', 'Miranda Richardson',
        'Kristin Scott-Thomas\'s Sister', 'Julia Ormond', 'Lara Pulver', 'Honeysuckle Weeks', 'Hermione Norris',
        'Keeley Hawes', 'Denise Van Outen', 'Anna Friel', 'Patsy Kensit', 'Jane Horrocks',
        'Caroline Quentin', 'Lesley Sharp', 'Julia Sawalha', 'Dawn French', 'Jennifer Saunders',
        'Joanna Lumley', 'Patricia Routledge', 'June Whitfield', 'Molly Sugden', 'Diana Dors',
        'Alina Korne', 'Lenka Krobotová', 'Klára Issová', 'Anna Šišková', 'Tatiana Vilhelmová',
        'Aňa Geislerová', 'Iva Janžurová', 'Dana Vávrová', 'Jitka Schneiderová', 'Zuzana Šulajová',
        'Mihaela Buzarnescu', 'Maia Morgenstern', 'Oana Pellea', 'Medeea Marinescu', 'Ada Condeescu',
        'Alina Grigore', 'Dorotheea Petre', 'Maria Dinulescu', 'Anamaria Marinca', 'Tora Vasilescu',
        'Marta Górnicka', 'Marta Rodo', 'Ewa Szykulska', 'Marta Lipińska', 'Kalina Hlimi-Pawlak',
        'Tilda Swinton', 'Shirley Henderson', 'Kelly Macdonald', 'Ashley Jensen', 'Laura Fraser',
        'Phyllis Logan', 'Siobhan Redmond', 'Elaine C. Smith', 'Maureen Carr', 'Eileen McCallum',
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
                'category' => 'movie_star',
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
        $this->command?->info("FemaleEuropeanActressesSeeder: {$created} created, {$skipped} skipped (out of {$total})");
    }
}
