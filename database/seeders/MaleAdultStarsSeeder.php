<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MaleAdultStarsSeeder extends Seeder
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
        'Rocco Siffredi', 'Ron Jeremy', 'Peter North', 'John Holmes', 'James Deen',
        'Manuel Ferrara', 'Keiran Lee', 'Johnny Sins', 'Danny D', 'Jordi El Niño Polla',
        'Ramon Nomar', 'Mick Blue', 'Erik Everhard', 'Nacho Vidal', 'Bruce Venture',
        'Chris Strokes', 'Prince Yahshua', 'Shane Diesel', 'Mark Ashley', 'Rico Strong',
        'Mandingo', 'Jules Jordan', 'Tommy Gunn', 'Mr. Marcus', 'Lexington Steele',
        'Wesley Pipes', 'Sean Michaels', 'Bobby Lathers', 'Jon Kortajarena', 'Nicki Hunter',
        'Tony Ribas', 'Alberto Rey', 'Steve Holmes', 'David Perry', 'Ian Scott',
        'Marco Rocca', 'Raul Cristian', 'Max Dior', 'Ryan McLane', 'Will Pounder',
        'Donny Sins', 'Lucas Frost', 'Jake Adams', 'Bill Bailey', 'Alex Legend',
        'Isiah Maxwell', 'Julian Jordon', 'Rob Banks', 'Jason Luv', 'Antonio Black',
        'Jack Vegas', 'Van Wylde', 'Jovan Jordan', 'Damion Dayski', 'Moe Johnson',
        'Dane Cross', 'Nat Turnher', 'Charlie Mac', 'Mark Zane', 'Talon',
        'Seth Gamble', 'Ryan Madison', 'Tyler Nixon', 'Small Hands', 'Xander Corvus',
        'Lucas Frost', 'Chad White', 'Jon Jon', 'Ricky Johnson', 'Michael Stefano',
        'Donny D', 'Mike Adriano', 'Chris Diamond', 'Karlo Karrera', 'Anthony Rosano',
        'Alex Mack', 'Kurt Lockwood', 'John Strong', 'Derek Pierce', 'Lee Stone',
        'Porn King', 'Otto Bauer', 'Paul Chaplin', 'Jake Taylor', 'Bill Clinton',
        'Jessy Jones', 'Claudio Meloni', 'Greg Centauro', 'Frank Major', 'Jessy',
        'Max Raptor', 'Marcus London', 'Robby D.', 'Vince Carter', 'Sledge Hammer',
        'Mickey G.', 'Brian Pumper', 'Nasty Man', 'Jack Hammer', 'Mike Hash',
        'Mike Horner', 'T.T. Boy', 'Don Fernando', 'Tony Eveready', 'Randy Spears',
        'Marc Wallice', 'Tom Byron', 'Joey Silvera', 'Rick Masters', 'Sebastian Barrio',
        'Anthony Crane', 'David Aaron', 'Jack Spade', 'Alex Sanders', 'Mike Foster',
        'Dave Cummings', 'Steve Austin', 'Bobby Vitale', 'Johnni Black', 'Eric Masterson',
        'Herschel Savage', 'Jamie Gillis', 'Johnnie Black', 'Nick East', "Peter O'Toole",
        'Rod Fontana', 'Steve Drake', 'Tony Martino', 'Billy Glide', 'Brad Armstrong',
        'Brett Sinclair', 'Chad Thomas', 'Cheyne Collins', 'Chris Charming', 'Curtis Rivers',
        'Damon Dice', 'Dave Hardman', 'Dick James', 'Don Hollywood', 'Eddie Jaye',
        'Elvis Bujold', 'Eric Evans', 'Evan Stone', 'Frankie M', 'George Rivera',
        'Guy DiSilva', 'Ian Tate', 'Iron Head', 'Jack Lawrence', 'Jackson Price',
        'Jake Malone', 'Jake Steed', 'Jake Williams', 'James Bonn', 'James Lewis',
        'Jamie Reeves', 'Jay Ashley', 'Jay Huntington', 'Jay Rock', 'Jeep',
        'Jerry Butler', 'Jimmy Bud', 'Jimmy Z', 'Joe Foster', 'John Decker',
        'John Doe', 'John E. Danger', 'John French', 'John Legend', 'John Miller',
        'John West', 'Johnny Rocket', 'Johnny Toxic', 'Jon Dough', 'Jon Stone',
        'Jordan Kingsley', 'Jordan Steel', 'Jose Duval', 'Josh Milan', 'Josh West',
        'Julian Andretti', 'Julian St. Jox', 'Justin Case', 'Justin Long', 'Justin Magnum',
        'Justin Slayer', 'Kai Taylor', "Kane O'Farrell", 'Ken Ryker', 'Ken Turner',
        'Keni Styles', 'Kevin Day', 'Kevin Moore', 'Kevin Patrick', 'Kyle Houston',
        'Kyle Stone', 'L.T. Turner', 'Lance Hart', 'Larry Black', 'Lee Chase',
        'Lex Erickson', 'Lex Luthor', 'Lionel Playworld', 'Luis Alvarez', 'Luke Hotrod',
        'Mack Stevens', 'Mario Rossi', 'Mark Anthony', 'Mark Davis', 'Mark Sloan',
        'Mark Wood', 'Martin Gunn', 'Marty Roman', 'Mason Stone', 'Master Shane',
        'Matt Gunther', 'Matt Silver', 'Matthew Rush', 'Max Black', 'Max Payne',
        'Michael Black', 'Michael Brandon', 'Michael Cruz', 'Michael Dark', 'Michael Knight',
        'Michael Masters', 'Michael Raven', 'Michael Starr', 'Michael Stone', 'Michael Troy',
        'Michael Vegas', 'Michael Vincent', 'Michael Williams', 'Mick Jay', 'Micky Ray',
        'Mike Dean', 'Mike Long', 'Mike Mancini', 'Mike Mike', 'Mike Quasar',
        'Mike Reynolds', 'Mike South', 'Mike Stone', 'Miles Long', 'Mitch Ryder',
        'Moe Bumps', 'Morgan Lee', 'Mr. Pete', 'Micky Bricks', 'Nate Dogg',
        'Nate Turner', 'Nathaniel', 'Neil Steele', 'Nick Knight', 'Nick Manning',
        'Nick Nack', 'Nick North', 'Nick Roman', 'Nick Wheeler', 'Nicki Hunter',
        'Nico Bellissimo', 'Nikos', 'Nino Bacci', 'Nino DeAngelo', 'Noah Bogart',
        'Omar Galanti', 'Omar Williams', 'Orlando', 'Otis Lee', 'Owen Gray',
        'Pablo Ferrari', 'Paco', 'Pat Myne', 'Patrick Bateman', 'Paul Carrigan',
        'Paul Fishbein', 'Paul Morgan', 'Paul Thomas', 'Percy Berkley', 'Peter Burnett',
        'Peter Gates', 'Peter Jennings', 'Peter North', 'Peter Onan', 'Peter Piper',
        'Phil Hardin', 'Phil Hollyday', 'Phil Maxum', 'Pierre Roshan', 'Pike Nelson',
        'Randy Hart', 'Randy Leeroy', 'Randy McCallister', 'Randy Moore', 'Randy West',
        'Raphael Garcia', 'Rasheed', 'Ray Charles', 'Ray Hell', 'Ray Lexi',
        'Ray Ray', 'Raymond Balboa', 'Redd Foxx', 'Reed Butler', 'Renato',
        'Rex Chandler', 'Rex Rubis', 'Ricardo Bell', 'Rich Handsome', 'Richard Black',
        'Richard Mann', 'Rick Masters', "Rick O'Shea", 'Rick Steele', 'Ricky Rock',
        'Ricky Starks', 'Rico Orozco', 'Rico Suave', 'Ripper', 'Rob Carpenter',
        'Rob E. Frost', 'Rob Nelson', 'Rob Rotten', 'Rob Steiner', 'Robby Apples',
        'Robby D', 'Robby Echo', 'Robby Stone', 'Robert Black', 'Robert Bullock',
        'Robert DeMarco', 'Robert Michaels', 'Robert Patrick', 'Roberto Beltran', 'Roberto Malone',
        'Rock Steele', 'Rocky Jackson', 'Rod Barry', 'Rod Gittens', 'Rod London',
        'Rod Masters', 'Rod Peterson', 'Rod Tower', 'Rodney Dawes', 'Rodney Moore',
        'Roger Daniels', 'Roger Dawson', 'Roger Lee', 'Roger Thomas', 'Rokki',
        'Roman Rivers', 'Romeo', 'Ron Jeremy', 'Ron Wesley', 'Ronald Lloyd',
        'Ronn Washington', 'Ronnie King', 'Ronnie Ray', 'Ross Hurston', 'Roxx',
        'Roy Lee', 'Roy Mitchell', 'Rusty Adams', 'Ryan Adams', 'Ryan Alexander',
        'Ryan Collins', 'Ryan Conner', 'Ryan Driller', 'Ryan James', 'Ryan Jean',
        'Ryan Knox', 'Ryan Lee', 'Ryan Lord', 'Ryan Madison', 'Ryan Mann',
        'Ryan McClane', 'Ryan Monroe', 'Ryan Neil', 'Ryan Patrick', 'Ryan Reed',
        'Ryan Reynolds', 'Ryan Ross', 'Ryan Ryder', 'Ryan Sash', 'Ryan Sexton',
        'Ryan Slater', 'Ryan Smiles', 'Ryan Star', 'Ryan Steele', 'Ryan Stone',
        'Ryan Thomas', 'Ryan Wagner', 'Ryan West', 'Ryan Wilcox', 'Ryder Ray',
        'Sacha', 'Salem', 'Salvador', 'Sam Bourque', 'Sam Elliott',
        'Sam French', 'Sam M.', 'Sam Strong', 'Sam Taylor', 'Sam Williams',
        'Sammy Cruz', 'Sammy Jay', "Samuel O'Neil", 'Santiago', 'Santo',
        'Santos', 'Sarge', 'Saul', 'Savannah', 'Saxon',
        'Scott Alexander', 'Scott Anders', 'Scott Andrews', 'Scott Austin', 'Scott Baker',
        'Scott Black', 'Scott Chase', 'Scott Clark', 'Scott Cole', 'Scott Davis',
        'Scott Evans', 'Scott Ford', 'Scott Fox', 'Scott Free', 'Scott Gregory',
        'Scott Harris', 'Scott Hayes', 'Scott Holt', 'Scott Hughes', 'Scott Hunter',
        'Scott Irwin', 'Scott James', 'Scott Jenkins', 'Scott Johnson', 'Scott Jones',
        'Scott Jordan', 'Scott Kelly', 'Scott King', 'Scott Kyle', 'Scott Lane',
        'Scott Lawrence', 'Scott Lee', 'Scott Lewis', 'Scott Lynch', 'Scott Lyons',
        'Scott Mack', 'Scott Mason', 'Scott Matthews', 'Scott Miller', 'Scott Mitchell',
        'Scott Moore', 'Scott Morgan', 'Scott Morris', 'Scott Murphy', 'Scott Nelson',
        'Scott Newman', 'Scott Nichols', "Scott O'Neil", 'Scott Palmer', 'Scott Parker',
        'Scott Peterson', 'Scott Phillips', 'Scott Powers', 'Scott Price', 'Scott Quinn',
        'Scott Ramsey', 'Scott Reed', 'Scott Reynolds', 'Scott Richards', 'Scott Richardson',
        'Scott Riley', 'Scott Roberts', 'Scott Robertson', 'Scott Robinson', 'Scott Rogers',
        'Scott Ross', 'Scott Russell', 'Scott Ryan', 'Scott Sanders', 'Scott Schultz',
        'Scott Scott', 'Scott Shaffer', 'Scott Shaw', 'Scott Shepherd', 'Scott Sherman',
        'Scott Sims', 'Scott Sinclair', 'Scott Slater', 'Scott Smith', 'Scott Spencer',
        'Scott Stevens', 'Scott Stewart', 'Scott Stone', 'Scott Sullivan', 'Scott Summers',
        'Scott Tanner', 'Scott Taylor', 'Scott Thomas', 'Scott Thompson', 'Scott Turner',
        'Scott Tyler', 'Scott Vaughn', 'Scott Walker', 'Scott Walters', 'Scott Ward',
        'Scott Warren', 'Scott Washington', 'Scott Watson', 'Scott Wayne', 'Scott Webb',
        'Scott Wells', 'Scott West', 'Scott White', 'Scott Williams', 'Scott Wilson',
        'Scott Winters', 'Scott Wolf', 'Scott Wood', 'Scott Woods', 'Scott Young',
        'Sean Adams', 'Sean Andrews', 'Sean Austin', 'Sean Baker', 'Sean Black',
        'Sean Bond', 'Sean Campbell', 'Sean Carpenter', 'Sean Casey', 'Sean Chase',
        'Sean Christian', 'Sean Collins', 'Sean Cooper', 'Sean Davis', 'Sean Diamond',
        'Sean Edwards', 'Sean Elliot', 'Sean Evans', 'Sean Fox', 'Sean Garrett',
        'Sean Grier', 'Sean Harris', 'Sean Hunter', 'Sean James', 'Sean Johnson',
        'Sean Jones', 'Sean Kelly', 'Sean King', 'Sean Law', 'Sean Lee',
        'Sean Lewis', 'Sean Logan', 'Sean Lucas', 'Sean Lyons', 'Sean Mann',
        'Sean Martin', 'Sean Masters', 'Sean Matthews', 'Sean Michaels', 'Sean Miller',
        'Sean Mitchell', 'Sean Moore', 'Sean Morgan', 'Sean Morris', 'Sean Murphy',
        "Sean O'Riley", 'Sean Patrick', 'Sean Peters', 'Sean Powers', 'Sean Price',
        'Sean Reed', 'Sean Reynolds', 'Sean Richards', 'Sean Roberts', 'Sean Ross',
        'Sean Ryder', 'Sean S.', 'Sean Sanders', 'Sean Shaw', 'Sean Silver',
        'Sean Slater', 'Sean Smith', 'Sean Steele', 'Sean Stone', 'Sean Taylor',
        'Sean Thomas', 'Sean Thompson', 'Sean Turner', 'Sean Tyler', 'Sean Walker',
        'Sean Washington', 'Sean Watson', 'Sean Wayne', 'Sean Williams', 'Sean Wilson',
        'Sebastian Solo', 'Sebastian Young', 'Sergio', 'Seth Dickerson', 'Shane Adams',
        'Shane Blair', 'Shane Brown', 'Shane Clark', 'Shane Collins', 'Shane Cooper',
        'Shane Daniels', 'Shane Davis', 'Shane Dawson', 'Shane Doe', 'Shane Fox',
        'Shane James', 'Shane Johnson', 'Shane Jones', 'Shane Kelly', 'Shane Lee',
        'Shane Michaels', 'Shane Miller', 'Shane Mitchell', 'Shane Moore', 'Shane Morgan',
        'Shane Morris', 'Shane Murphy', 'Shane Nelson', 'Shane Peters', 'Shane Reed',
        'Shane Reynolds', 'Shane Roberts', 'Shane Robinson', 'Shane Rogers', 'Shane Russo',
        'Shane Scott', 'Shane Smith', 'Shane Stevens', 'Shane Stone', 'Shane Taylor',
        'Shane Thomas', 'Shane Thompson', 'Shane Walker', 'Shane Walsh', 'Shane Williams',
        'Shane Wilson', 'Shawn Alexander', 'Shawn Black', 'Shawn Brady', 'Shawn Brown',
        'Shawn Dean', 'Shawn Diesel', 'Shawn Fox', 'Shawn Green', 'Shawn Knight',
        'Shawn Lee', 'Shawn Michaels', 'Shawn Miller', 'Shawn Roberts', 'Shawn Rose',
        'Shawn Ryden', 'Shawn Steele', 'Shawn Stone', 'Shawn Tyson', 'Shawnee',
        'Shay Michaels', 'Sheldon', 'Sherman', 'Shiloh', 'Shocker',
        'Sicily', 'Sidney', 'Sierra', 'Silas Stone', 'Silver',
        'Simone', 'Sin', 'Sinful', 'Sir', 'Sirus',
        'Skeet', 'Skylar', 'Slade', 'Slater', 'Slick',
        'Sloan Harper', 'Sly', 'Smokie', 'Smooth', 'Snake',
        'Sniper', 'Snoop', 'Snow', 'Solo', 'Sonny',
        'Soul', 'Spencer', 'Spike', 'Spitfire', 'Splash',
        'Spoiler', 'Spyder', 'Stacy', 'Stan Lee', 'Stanley',
        'Star', 'Stavros', 'Stealth', 'Steel', 'Steele',
        'Stefan', 'Stella', 'Stephan', 'Stephen', 'Steve Austin',
        'Steve B.', 'Steve Black', 'Steve Bond', 'Steve Burns', 'Steve Carter',
        'Steve Chase', 'Steve Clark', 'Steve Cole', 'Steve Cox', 'Steve Cruz',
        'Steve C.', 'Steve D.', 'Steve Davis', 'Steve Drake', 'Steve East',
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
                'category' => 'adult_star',
                'avatar' => Celebrity::avatarUrlFor($name),
                'cover_photo' => Celebrity::coverUrlFor($slug),
                'gender' => 'male',
                'country' => 'United States',
                'is_active' => true,
                'social_links' => [],
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
        $this->command?->info("MaleAdultStarsSeeder: {$created} created, {$skipped} skipped (out of {$total})");
    }
}
