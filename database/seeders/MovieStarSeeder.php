<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MovieStarSeeder extends Seeder
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
    ];

    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@managingteam.info'],
            ['name' => 'Admin', 'password' => Hash::make('admin123!'), 'role' => 'admin', 'is_verified' => true]
        );

        $actors = [
            ['name' => 'Samuel L. Jackson', 'bio' => 'Iconic actor with over 150 film credits. Known for Pulp Fiction, Die Hard with a Vengeance, the Avengers franchise, and Star Wars prequels. The highest-grossing actor of all time worldwide.'],
            ['name' => 'Jeff Bridges', 'bio' => 'Oscar-winning actor known for The Big Lebowski, Crazy Heart (Academy Award for Best Actor), True Grit, Tron, and Hell or High Water. A versatile leading man for five decades.'],
            ['name' => 'Richard Gere', 'bio' => 'Hollywood leading man known for Pretty Woman, An Officer and a Gentleman, Chicago, American Gigolo, and Primal Fear. Also a dedicated humanitarian and activist.'],
            ['name' => 'Bill Murray', 'bio' => 'Beloved comedic and dramatic actor known for Ghostbusters, Groundhog Day, Lost in Translation (Oscar nomination), The Grand Budapest Hotel, and Rushmore. SNL legend.'],
            ['name' => 'Kurt Russell', 'bio' => 'Veteran actor known for Escape from New York, The Thing, Big Trouble in Little China, Tombstone, and Guardians of the Galaxy Vol. 2. Began his career as a child actor for Disney.'],
            ['name' => 'Michael Keaton', 'bio' => 'Acclaimed actor known for Batman (1989), Beetlejuice, Birdman (Oscar nomination), Spotlight, The Founder, and Dopesick (Emmy win). Master of both comedy and drama.'],
            ['name' => 'John Malkovich', 'bio' => 'Renowned character actor and producer. Known for Being John Malkovich, Dangerous Liaisons, In the Line of Fire (Oscar nomination), Of Mice and Men, and Con Air. A stage legend.'],
            ['name' => 'Bill Pullman', 'bio' => 'Versatile actor known for Independence Day, While You Were Sleeping, Spaceballs, Sleepless in Seattle, and the Murder Mystery franchise. Also an accomplished stage director.'],
            ['name' => 'Denzel Washington', 'bio' => 'Two-time Oscar winner widely regarded as one of the greatest actors of his generation. Known for Training Day (Oscar win), Malcolm X, Glory, Fences, The Equalizer, and Philadelphia.'],
            ['name' => 'Jeff Daniels', 'bio' => 'Emmy-winning actor known for Dumb and Dumber, The Martian, The Squid and the Whale, Terms of Endearment, and the acclaimed TV series The Newsroom and Godless.'],
            ['name' => 'Bruce Willis', 'bio' => 'Iconic action star known for the Die Hard franchise, Pulp Fiction, The Sixth Sense, Unbreakable, and Sin City. Retired from acting due to aphasia diagnosis.'],
            ['name' => 'Willem Dafoe', 'bio' => 'Acclaimed character actor with four Oscar nominations. Known for Spider-Man (Green Goblin), Platoon, The Florida Project, The Lighthouse, At Eternity\'s Gate, and Poor Things.'],
            ['name' => 'Mel Gibson', 'bio' => 'Oscar-winning actor and director known for Braveheart (Oscar win), Mad Max / Mad Max 2, the Lethal Weapon franchise, The Passion of the Christ, and Hacksaw Ridge.'],
            ['name' => 'Tom Hanks', 'bio' => 'Two-time Oscar winner and beloved American icon. Known for Forrest Gump, Philadelphia, Cast Away, Saving Private Ryan, Apollo 13, and the Toy Story franchise as Woody.'],
            ['name' => 'Bryan Cranston', 'bio' => 'Emmy-winning actor known for Breaking Bad (widely considered one of the greatest TV dramas ever), Malcolm in the Middle, Trumbo (Oscar nomination), Your Honor, and All the Way.'],
            ['name' => 'Kevin Bacon', 'bio' => 'Prolific actor known for Footloose, A Few Good Men, Apollo 13, Mystic River, Stir of Echoes, and the TV series The Following. Famous for the "Six Degrees of Kevin Bacon" phenomenon.'],
            ['name' => 'Tim Robbins', 'bio' => 'Oscar-winning actor and director known for The Shawshank Redemption, Mystic River (Oscar win for Best Supporting Actor), Bull Durham, Jacob\'s Ladder, and Dead Man Walking.'],
            ['name' => 'Sean Penn', 'bio' => 'Two-time Oscar winner known for Milk (Oscar win), Mystic River (Oscar win), Dead Man Walking, Fast Times at Ridgemont High, and Into the Wild. Also an accomplished director and activist.'],
            ['name' => 'George Clooney', 'bio' => 'Oscar-winning actor, director, and producer. Known for Ocean\'s Eleven franchise, Syriana (Oscar win), Gravity, The Descendants, ER, Good Night and Good Luck, and The Monuments Men.'],
            ['name' => 'Woody Harrelson', 'bio' => 'Versatile actor known for Cheers, Natural Born Killers, The People vs. Larry Flynt (Oscar nomination), Zombieland, True Detective, Three Billboards Outside Ebbing, Missouri, and Venom.'],
            ['name' => 'Tom Cruise', 'bio' => 'One of the biggest movie stars in history and a three-time Oscar nominee. Known for the Mission: Impossible franchise, Top Gun, Jerry Maguire, Rain Man, Born on the Fourth of July, and Risky Business. Famous for performing his own stunts.'],
            ['name' => 'Steve Carell', 'bio' => 'Comedic and dramatic actor known for The Office (US) as Michael Scott, The 40-Year-Old Virgin, Little Miss Sunshine, Foxcatcher (Oscar nomination), Beautiful Boy, and The Morning Show.'],
            ['name' => 'Jim Carrey', 'bio' => 'Legendary comedic actor known for Ace Ventura, The Mask, Dumb and Dumber, The Truman Show, Eternal Sunshine of the Spotless Mind, Liar Liar, and Man on the Moon (Golden Globe win).'],
            ['name' => 'Johnny Depp', 'bio' => 'Versatile actor and producer known for the Pirates of the Caribbean franchise, Edward Scissorhands, Finding Neverland, Sweeney Todd, Charlie and the Chocolate Factory, and Fantastic Beasts.'],
            ['name' => 'Brad Pitt', 'bio' => 'Oscar-winning actor and producer known for Fight Club, Once Upon a Time in Hollywood (Oscar win), The Curious Case of Benjamin Button, Moneyball, Bullet Train, and Ocean\'s Eleven. Co-founder of Plan B Entertainment.'],
            ['name' => 'Nicolas Cage', 'bio' => 'Oscar-winning actor known for Leaving Las Vegas (Academy Award for Best Actor), Face/Off, National Treasure, Adaptation, Con Air, The Rock, and Pig. Known for his intense, unique acting style.'],
            ['name' => 'Keanu Reeves', 'bio' => 'Beloved action star known for The Matrix trilogy, the John Wick franchise, Speed, Point Break, Bill & Ted\'s Excellent Adventure, and The Devil\'s Advocate. Widely admired for his kindness and philanthropy.'],
            ['name' => 'Don Cheadle', 'bio' => 'Acclaimed actor known for Hotel Rwanda (Oscar nomination), Crash (ensemble Oscar), the Ocean\'s Eleven franchise, Iron Man 2 / Avengers (War Machine), Boogie Nights, and House of Lies.'],
            ['name' => 'Robert Downey Jr.', 'bio' => 'Oscar-winning actor who rose to become one of Hollywood\'s highest-paid stars. Known for Iron Man / Avengers (MCU), Sherlock Holmes, Chaplin (Oscar nomination), Oppenheimer (Oscar win), and Tropic Thunder (Oscar nomination).'],
            ['name' => 'Ben Stiller', 'bio' => 'Comedic actor, writer, and director known for Zoolander, Meet the Parents, There\'s Something About Mary, Night at the Museum, Dodgeball, and Tropic Thunder (which he also directed).'],
            ['name' => 'John Cusack', 'bio' => 'Cult favorite actor known for Say Anything, Grosse Pointe Blank, High Fidelity, Being John Malkovich, 1408, The Grifters, and Con Air. A defining figure of 80s and 90s cinema.'],
            ['name' => 'Adam Sandler', 'bio' => 'Comedic actor, writer, and producer known for Billy Madison, Happy Gilmore, The Wedding Singer, 50 First Dates, and critically acclaimed dramatic roles in Uncut Gems and Hustle. SNL legend.'],
            ['name' => 'Will Smith', 'bio' => 'Oscar-winning actor, producer, and global superstar. Known for Men in Black, Independence Day, Bad Boys, The Fresh Prince of Bel-Air, Ali (Oscar nomination), and King Richard (Oscar win). Grammy-winning rapper.'],
            ['name' => 'Owen Wilson', 'bio' => 'Comedic actor known for Wedding Crashers, Zoolander, The Royal Tenenbaums, Midnight in Paris, Cars (Lightning McQueen), the Loki TV series, and Bottle Rocket. Frequent Wes Anderson collaborator.'],
            ['name' => 'Edward Norton', 'bio' => 'Oscar-nominated actor known for Fight Club, American History X, Primal Fear, The Incredible Hulk, Birdman, The Grand Budapest Hotel, Glass Onion, and Motherless Brooklyn (which he also directed).'],
            ['name' => 'Paul Rudd', 'bio' => 'Beloved comedic and dramatic actor known for Anchorman, The 40-Year-Old Virgin, Knocked Up, Role Models, Ant-Man / Avengers (MCU), and the TV series Friends and The Morning Show. People\'s Sexiest Man Alive 2021.'],
            ['name' => 'Matthew McConaughey', 'bio' => 'Oscar-winning actor known for Dallas Buyers Club (Academy Award for Best Actor), Interstellar, True Detective (Emmy nomination), The Wolf of Wall Street, Dazed and Confused, and Magic Mike. Author of the memoir "Greenlights."'],
            ['name' => 'Mark Ruffalo', 'bio' => 'Oscar-nominated actor known for Spotlight, the Avengers franchise (The Hulk), Foxcatcher, The Kids Are All Right, Zodiac, Dark Waters, and the Emmy-winning TV series I Know This Much Is True.'],
            ['name' => 'Jamie Foxx', 'bio' => 'Oscar-winning actor and Grammy-winning musician. Known for Ray (Academy Award for Best Actor), Collateral (Oscar nomination), Django Unchained, Baby Driver, In Living Color, and The Jamie Foxx Show.'],
            ['name' => 'Will Ferrell', 'bio' => 'Comedic icon and SNL legend known for Anchorman, Step Brothers, Talladega Nights, Elf, Old School, Stranger Than Fiction, and Blades of Glory. Co-founder of the comedy website Funny or Die.'],
            ['name' => 'Vince Vaughn', 'bio' => 'Comedic and dramatic actor known for Swingers, Wedding Crashers, Old School, The Break-Up, Dodgeball, and the dramatic role in True Detective season 2. Known for his fast-talking improvisational style.'],
            ['name' => 'Matt Damon', 'bio' => 'Oscar-winning actor, screenwriter, and producer. Known for Good Will Hunting (Oscar for screenwriting), the Bourne franchise, The Martian (Oscar nomination), Saving Private Ryan, Interstellar, and Oppenheimer.'],
            ['name' => 'Hugh Jackman', 'bio' => 'Australian actor and producer known for Wolverine in the X-Men franchise, Les Misérables (Oscar nomination / Golden Globe win), The Greatest Showman, Logan, Prisoners, and The Prestige. Also a Tony-winning stage performer.'],
            ['name' => 'Mark Wahlberg', 'bio' => 'Actor and producer known for The Departed, Ted, the Transformers franchise, Boogie Nights, The Fighter (Oscar nomination), Deepwater Horizon, and the TV series Entourage (producer). Began his career as rapper Marky Mark.'],
            ['name' => 'Ben Affleck', 'bio' => 'Oscar-winning actor, director, and screenwriter. Known for Good Will Hunting (Oscar for screenwriting), Argo (Oscar for Best Picture), Gone Girl, The Town, Batman v Superman, and Air. Also a celebrated director.'],
            ['name' => 'Dwayne Johnson', 'bio' => 'Highest-paid actor in Hollywood and former WWE champion. Known for the Fast & Furious franchise, Jumanji: Welcome to the Jungle, Moana (voice of Maui), Black Adam, San Andreas, and Ballers. One of the most followed people on Instagram.'],
            ['name' => 'Vin Diesel', 'bio' => 'Action star and producer known for the Fast & Furious franchise, xXx, Pitch Black / The Riddick series, Saving Private Ryan, and voicing Groot in the Guardians of the Galaxy / Avengers (MCU) films.'],
            ['name' => 'Christian Bale', 'bio' => 'Oscar-winning actor known for his immersive transformations. Known for The Dark Knight trilogy (Batman), American Psycho, The Fighter (Oscar win), Vice, Ford v Ferrari, American Hustle, and The Prestige.'],
            ['name' => 'Leonardo DiCaprio', 'bio' => 'Oscar-winning actor and environmental activist. Known for Titanic, Inception, The Wolf of Wall Street, The Revenant (Academy Award for Best Actor), Django Unchained, Once Upon a Time in Hollywood, and Killers of the Flower Moon.'],
            ['name' => 'Ryan Reynolds', 'bio' => 'Canadian comedic action star known for Deadpool (which he championed for a decade), The Proposal, Free Guy, Red Notice, the Hitman\'s Bodyguard franchise, and Spirited. Also a successful entrepreneur (Mint Mobile, Aviation Gin).'],
            ['name' => 'Tom Hardy', 'bio' => 'British actor known for Mad Max: Fury Road, Inception, The Dark Knight Rises (Bane), Venom, Warrior, Bronson, Legend, and the TV series Peaky Blinders and Taboo. Also an accomplished producer.'],
            ['name' => 'Chris Pratt', 'bio' => 'Actor known for Guardians of the Galaxy (Star-Lord), Jurassic World, The Lego Movie, Parks and Recreation (Andy Dwyer), and The Super Mario Bros. Movie (voicing Mario). One of Hollywood\'s most bankable stars.'],
            ['name' => 'John Krasinski', 'bio' => 'Actor, director, and writer known for The Office (Jim Halpert), A Quiet Place (which he co-wrote and directed), Jack Ryan, 13 Hours: The Secret Soldiers of Benghazi, and IF. Also the creator of "Some Good News."'],
            ['name' => 'Jason Momoa', 'bio' => 'Actor and producer known for Aquaman (DC Extended Universe), Game of Thrones (Khal Drogo), Dune, See (Apple TV+), and the Fast & Furious franchise. An environmental activist for ocean conservation.'],
            ['name' => 'Jake Gyllenhaal', 'bio' => 'Acclaimed actor known for Brokeback Mountain, Nightcrawler, Prisoners, Zodiac, Southpaw, Donnie Darko, The Guilty, and Spider-Man: Far From Home. Known for choosing challenging and diverse roles.'],
            ['name' => 'Ryan Gosling', 'bio' => 'Canadian actor known for The Notebook, Drive, La La Land (Golden Globe win / Oscar nomination), Blade Runner 2049, Barbie, Crazy Stupid Love, and Blue Valentine. Also a musician in the band Dead Man\'s Bones.'],
            ['name' => 'Chris Evans', 'bio' => 'American actor best known for playing Captain America in the Marvel Cinematic Universe. Also known for Knives Out, The Gray Man, Gifted, Snowpiercer, Scott Pilgrim vs. the World, and the TV series Defending Jacob.'],
            ['name' => 'Joseph Gordon-Levitt', 'bio' => 'Actor, director, and entrepreneur. Known for Inception, 500 Days of Summer, The Dark Knight Rises, Looper, Snowden, and the TV series 3rd Rock from the Sun. Founder of the online production community HitRecord.'],
            ['name' => 'Channing Tatum', 'bio' => 'Actor and producer known for Magic Mike (which he also conceived), Step Up, 21 Jump Street, The Vow, Foxcatcher, Logan Lucky, and Dog (co-directed). Began his career as a dancer and model.'],
            ['name' => 'Chris Hemsworth', 'bio' => 'Australian actor known for playing Thor in the Marvel Cinematic Universe. Also known for The Avengers, Rush, Extraction, Snow White and the Huntsman, Bad Times at the El Royale, and the documentary series Limitless.'],
            ['name' => 'Michael B. Jordan', 'bio' => 'Actor and director known for Creed (franchise), Black Panther (Killmonger), Fruitvale Station, Just Mercy, Without Remorse, and Creed III (directorial debut). Also an executive producer on multiple projects.'],
            ['name' => 'Glen Powell', 'bio' => 'Rising star known for Top Gun: Maverick, Anyone but You, Hit Man, Twisters, Hidden Figures, and Scream Queens. Also an accomplished writer and producer.'],
            ['name' => 'Austin Butler', 'bio' => 'Rising actor known for Elvis (Oscar nomination / Golden Globe win), Dune: Part Two (Feyd-Rautha), Once Upon a Time in Hollywood, Masters of the Air, and The Carrie Diaries.'],
            ['name' => 'Ansel Elgort', 'bio' => 'Actor and DJ known for Baby Driver, The Fault in Our Stars, West Side Story (2021), and the Divergent Series. Also performs electronic music under his own name.'],
            ['name' => 'Timothée Chalamet', 'bio' => 'Young acclaimed actor known for Call Me by Your Name (Oscar nomination), the Dune franchise (Paul Atreides), Beautiful Boy, Little Women, Wonka, Bones and All, and the Bob Dylan biopic A Complete Unknown.'],
            ['name' => 'Tom Holland', 'bio' => 'British actor known for playing Spider-Man in the Marvel Cinematic Universe. Also known for The Impossible, The Crowded Room, Cherry, Uncharted, The Devil All the Time, and the TV series Wolf Hall.'],
        ];

        foreach ($actors as $i => $actor) {
            $this->createCelebrity($admin, $actor, $i);
        }

        $this->command?->info('Seeded '.count($actors).' movie star celebrities!');
    }

    private function createCelebrity(User $admin, array $actor, int $index): Celebrity
    {
        $slug = Str::of($actor['name'])->slug();
        $palette = $this->colorPalettes[$index % count($this->colorPalettes)];
        $fonts = $this->fontPairings[$index % count($this->fontPairings)];

        $celeb = Celebrity::firstOrCreate(
            ['slug' => $slug],
            [
                'name' => $actor['name'],
                'bio' => $actor['bio'],
                'social_links' => [
                    'instagram' => 'https://instagram.com/'.str_replace('.', '', $slug),
                    'twitter' => 'https://twitter.com/'.str_replace('.', '', $slug),
                ],
                'config' => [
                    'site_content' => [
                        'hero_title' => 'Welcome to the Official<br><span class="gradient-text">'.e($actor['name']).'</span><br>Fan Community',
                        'hero_subtitle' => 'Join the most exclusive fan community. Access premium content, attend private events, and connect with fellow fans worldwide.',
                        'about_title' => 'About '.$actor['name'],
                        'about_body' => '<p>'.e($actor['bio']).'</p><p>This official fan community is your gateway to exclusive content, private events, and a direct connection to the '.e($actor['name']).' experience.</p>',
                        'stats' => [
                            ['value' => '40+', 'label' => 'Film Awards'],
                            ['value' => '100M+', 'label' => 'Box Office Gross'],
                            ['value' => '30+', 'label' => 'Years Active'],
                            ['value' => '50+', 'label' => 'Film Credits'],
                        ],
                        'testimonials' => [
                            ['author' => 'Alex M.', 'quote' => 'Being part of this community has been incredible! The exclusive content is amazing and worth every penny.', 'badge' => 'VIP Member'],
                            ['author' => 'Jordan K.', 'quote' => 'The meet & greet was unforgettable! I got to meet my idol and the whole experience was perfectly organized.', 'badge' => 'Premium Member'],
                            ['author' => 'Taylor R.', 'quote' => 'I joined as a Standard member and upgraded within a week. Best decision I ever made!', 'badge' => 'Standard Member'],
                        ],
                    ],
                    'theme' => [
                        'primary_color' => $palette['primary'],
                        'secondary_color' => $palette['secondary'],
                        'fonts' => $fonts,
                    ],
                    'membership_tiers' => [
                        [
                            'name' => 'Standard',
                            'price' => 3000,
                            'color' => '#C0C0C0',
                            'benefits' => [
                                'Exclusive community access',
                                'Monthly newsletter',
                                'Digital membership card',
                                'Exclusive fan badge',
                                'Direct messaging with team',
                            ],
                        ],
                        [
                            'name' => 'Premium',
                            'price' => 5000,
                            'color' => '#FFD700',
                            'benefits' => [
                                'Everything in Standard',
                                'Early access to events',
                                'Priority messaging',
                                'Exclusive monthly content',
                                'Member-only livestreams',
                                'Priority support',
                            ],
                        ],
                        [
                            'name' => 'VIP',
                            'price' => 10000,
                            'color' => '#E5E4E2',
                            'benefits' => [
                                'Everything in Premium',
                                'Quarterly 1-on-1 video call',
                                'Signed merchandise',
                                'Private meetup invitations',
                                'All-access pass',
                                'Personalized video message',
                                '24/7 priority support',
                                'Lifetime status badge',
                            ],
                        ],
                    ],
                    'features' => [
                        'fan_applications' => true,
                        'membership' => true,
                        'meet_greet' => true,
                        'membership_card' => true,
                        'private_meetup' => true,
                        'messaging' => true,
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
                ],
                'is_active' => true,
                'created_by' => $admin->id,
            ]
        );

        if ($celeb->wasRecentlyCreated) {
            $this->seedPaymentMethods($celeb);
        }

        $this->createFan($celeb, $index);

        return $celeb;
    }

    private function createFan(Celebrity $celeb, int $index): void
    {
        $slug = Str::of($celeb->name)->slug();
        $email = "{$slug}1@demo.com";

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $celeb->name.' Fan',
                'password' => Hash::make('demo1234!'),
                'role' => 'fan',
                'is_verified' => true,
            ]
        );

        if (! $user->celebrities()->where('celebrity_id', $celeb->id)->exists()) {
            $user->celebrities()->attach($celeb->id, ['status' => 'active']);
        }
    }

    private function seedPaymentMethods(Celebrity $celebrity): void
    {
        $celebrity->paymentMethods()->delete();
        $celebrity->paymentMethods()->createMany([
            [
                'type' => 'bank_transfer',
                'label' => 'Bank Transfer',
                'enabled' => true,
                'details' => [
                    'bank_name' => 'Chase Bank',
                    'account_name' => $celebrity->name.' Management LLC',
                    'account_number' => '1234567890',
                    'swift_code' => 'CHASUS33',
                    'instructions' => '<h4>How to pay via bank transfer:</h4><ul><li>Use your name as payment reference</li><li>Allow 1-3 business days for processing</li><li>Upload the receipt after transferring</li></ul>',
                ],
                'sort_order' => 1,
            ],
            [
                'type' => 'stripe',
                'label' => 'Credit/Debit Card',
                'enabled' => true,
                'details' => null,
                'sort_order' => 2,
            ],
            [
                'type' => 'cryptocurrency',
                'label' => 'Bitcoin',
                'enabled' => true,
                'details' => [
                    'network' => 'bitcoin',
                    'wallet_address' => 'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh',
                    'instructions' => '<p>Send BTC to the address above. <strong>Minimum: 0.001 BTC</strong>.</p>',
                ],
                'sort_order' => 3,
            ],
        ]);
    }
}
