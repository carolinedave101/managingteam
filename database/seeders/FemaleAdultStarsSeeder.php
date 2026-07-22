<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FemaleAdultStarsSeeder extends Seeder
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
        'Stormy Daniels', 'Jenna Jameson', 'Sunny Leone', 'Sasha Grey', 'Mia Khalifa',
        'Riley Reid', 'Lana Rhoades', 'Abella Danger', 'Kendra Sunderland', 'Mia Malkova',
        'Brandi Love', 'Lisa Ann', 'Nikki Benz', 'Tera Patrick', 'Jesse Jane',
        'Bree Olson', 'Sasha Grey\'s Twin', 'Asa Akira', 'Adriana Chechik', 'Angela White',
        'Eva Lovia', 'Remy LaCroix', 'Kagney Linn Karter', 'Lexi Belle', 'Stoya',
        'Joanna Angel', 'Maitland Ward', 'Demi Sutra', 'Karlee Grey', 'Kissa Sins',
        'Rae Lil Black', 'Vicki Chase', 'Cherie DeVille', 'Nina Hartley', 'Christy Canyon',
        'Ginger Lynn', 'Traci Lords', 'Hyapatia Lee', 'Nina Hartley\'s Sister', 'Seka',
        'Vanessa del Rio', 'Asia Carrera', 'Megan Foxx', 'Rachel Starr', 'Alektra Blue',
        'Alison Tyler', 'Amy Reid', 'Andy San Dimas', 'Anikka Albrite', 'April O\'Neil',
        'August Ames', 'Ava Addams', 'Belle Knox', 'Bianca Beauchamp', 'Bonnie Rotten',
        'Brittany Andrews', 'Brooklyn Chase', 'Capri Anderson', 'Carmen Hart', 'Cassidy Banks',
        'Celeste Star', 'Chanel Preston', 'Charisma Cappelli', 'Charlie Laine', 'Charlotte Stokely',
        'Chyna Chase', 'Claire Dames', 'Courtney Cummz', 'Crystal Clear', 'Daisy Marie',
        'Dana DeArmond', 'Dani Jensen', 'Danny Mountain', 'Diane Sellers', 'Dillion Harper',
        'Dustin Brooks', 'Ella Knox', 'Emily Addison', 'Emy Reyes', 'Erik Everhard\'s Partner',
        'Eva Angelina', 'Faye Runaway', 'Felony', 'Francesca Le', 'Frankie Diamond',
        'Gianna Michaels', 'Gracie Glam', 'Hannah Harper', 'Havana Ginger', 'Heather Hunter',
        'Heidi Mayne', 'Hillary Scott', 'Holly Sampson', 'Honey Wilds', 'India Summer',
        'Isabella Soprano', 'Jada Fire', 'Jade Hsu', 'Jana Jordan', 'Jayden Cole',
        'Jayden James', 'Jelena Jensen', 'Jenna Haze', 'Jennifer Dark', 'Jesse Capelli',
        'Jessica Drake', 'Jewell Marceau', 'Jiz Lee', 'Julia Ann', 'Justine Joli',
        'Kacey Lane', 'Kaitlyn Ashley', 'Kara Price', 'Karen Summer', 'Karla Lane',
        'Karmen Karma', 'Katalina Kyle', 'Katja Kassin', 'Kayden Kross', 'Kelly Divine',
        'Kelly Madison', 'Kerry Louise', 'Kimberly Kane', 'Kinzie Kenner', 'Kirsten Price',
        'Lacie Heart', 'Layla London', 'Leah Gotti', 'Leigh Raven', 'Leilani Leeane',
        'Lexi Love', 'Lily Carter', 'Lily Lane', 'Linda Lovelace', 'Lizz Tayler',
        'London Keyes', 'Lorena Sanchez', 'Lotus Lain', 'Lucy Lee', 'Madelyn Marie',
        'Malena Morgan', 'Mandy Muse', 'Manuel Ferrara\'s Partner', 'Maria Ozawa', 'Marie McCray',
        'Marina Angel', 'Mason Moore', 'Megan Jones', 'Melissa Monet', 'Mellanie Monroe',
        'Mia Bangg', 'Mia Rose', 'Michele James', 'Michelle Maylene', 'Mickey Lynn',
        'Miko Lee', 'Mina Lux', 'Misty Mundae', 'Molly Jane', 'Mona Wales',
        'Monique Alexander', 'Naomi Russell', 'Natalia Starr', 'Natasha Nice', 'Nellie Bones',
        'Nicole Aniston', 'Nina Mercedez', 'Nina Monet', 'Nina Rivera', 'Nina Rossi',
        'Nina Sinn', 'Nomi Malone', 'Olivia O\'Lovely', 'Paisley Rae', 'Pandora Blake',
        'Penny Barber', 'Penny Flame', 'Peta Jensen', 'Phoenix Marie', 'Pink Perfect',
        'Presley Hart', 'Princess Donna', 'Princess Leia', 'Puma Swede', 'Quintina Williams',
        'Rachele Richey', 'Raven Alexis', 'Raven Bay', 'Raya Steele', 'Raylene',
        'Rebeca Linares', 'Riley Evans', 'Riley Nixon', 'Riley Reid\'s Sister', 'Roxy Jezel',
        'Roxy Ray', 'Ruby Knox', 'Ryan Conner', 'Ryder Skye', 'Sabrina Banks',
        'Sabrina Deep', 'Sabrina Sparrow', 'Sadie West', 'Samantha Bentley', 'Samantha Ryan',
        'Sammie Rhodes', 'Sandee Westgate', 'Sandra Romain', 'Sara Jay', 'Sarah Jessie',
        'Sarah Rae', 'Sasha Knox', 'Satine Phoenix', 'Savannah Ford', 'Savannah Stern',
        'Scarlett Bloom', 'Scarlett Sage', 'Selah Rain', 'Serena Blair', 'Shanda Fay',
        'Shane Dos Santos', 'Shannon Kelly', 'Shawna Lenee', 'Shay Sights', 'Sheena Shaw',
        'Shelby Bell', 'Sienna West', 'Silvia Saint', 'Simone Sonay', 'Sinn Sage',
        'Siren Dior', 'Skin Diamond', 'Skye Blue', 'Sofia Rose', 'Sophie Dee',
        'Spencer Scott', 'Stephanie Swift', 'Stormy Waters', 'Sugar Lynn Beard', 'Summer Brielle',
        'Summer Hart', 'Sunny Lane', 'Sunny Leone\'s Sister', 'Susan Block', 'Sydney Cole',
        'Synthia Cruz', 'Talia Joy', 'Tana Lea', 'Tanya James', 'Tara Lynn Foxx',
        'Tasha Reign', 'Tatum Matthews', 'Taylor Vixen', 'Teanna Trump', 'Tera Joy',
        'Terri Summers', 'Texxxy', 'Tiffany Diamond', 'Tiffany Doll', 'Tiffany Tyler',
        'Tina Kay', 'Tina Yuzuki', 'Tommy King', 'Tori Black', 'Tory Lane',
        'Trinity St Clair', 'Tristan Stevens', 'Tyler Faith', 'Valerie Kay', 'Vanilla Sky',
        'Veronica Avluv', 'Veronica Hart', 'Veronica Rodriguez', 'Vicki Vette', 'Victoria Sweet',
        'Violet Monroe', 'Violet Starr', 'Wendy Summers', 'Whitney Westgate', 'Xander Corvus\'s Partner',
        'Yasmine de Leon', 'Yurizan Beltran', 'Zoe Doll', 'Zoe Voss', 'Angelina Castro',
        'Chanel Santini', 'Daisy Lynn', 'Elena Koshka', 'Emily Willis', 'Gia Paige',
        'Harley Jade', 'Jane Wilde', 'Kenzie Anne', 'Kyler Quinn', 'Lacy Lennon',
        'LaSirena69', 'Lena Paul', 'Lily Larimar', 'Liv Revamped', 'Maddy Belle',
        'Naomi Swann', 'Natalia Queen', 'Pepper Hart', 'Romi Rain', 'Ryan Maddie',
        'Sera Ryder', 'Skyler Lo', 'Slay Queen', 'Sofi Ryan', 'Star Orders',
        'Vanna Bardot', 'Violet Myers', 'Avery Black', 'Brittany Renner', 'Coi Leray\'s Sister',
        'Corinna Kopf', 'Daisy Keech', 'Eva Elfie', 'Hannah Palmer', 'Hotkarli',
        'Jailyne Ojeda', 'Jordyn Jones', 'Katie Sigmond', 'Lauren Alexis', 'Lena Nersesian',
        'Liliana Hearts', 'Malu Trevejo', 'Megnut', 'Mikayla Demaiter', 'Molly Eskam',
        'Nuria Gosalvez', 'Olivia Ponton', 'Pamibaby', 'Payton Preslee', 'Riley Curry\'s Twin',
        'Seltin Sweety', 'Sommer Ray', 'Staryuki', 'Sunny Ray', 'Tana Mongeau',
        'Taylor McCool', 'Tenny', 'TheLilacQueen', 'Tiare', 'Valentina Garzon',
        'Wett Melanin', 'Yanet Garcia', 'Yovanna Ventura', 'Zoe Moore', 'Aella',
        'Alahna Ly', 'Alexa Pearl', 'Alice Bong', 'Alina Belle', 'Amanda Elise',
        'Analucia', 'Anastasia Kvitko', 'Angela Agnus', 'Anna Faith', 'Annie LeBlanc\'s Sister',
        'Aryia', 'Ashley Tervort', 'Barbara Palvin\'s Sister', 'Belle Jade', 'Belle Rose',
        'Blair Winters', 'Boomer Banks', 'Brazzers Model', 'Bunny Colby', 'Camila Cortez',
        'Caribbean Kitty', 'Carol Wayne', 'Carolina Sweets', 'Cassidy Klein', 'Catherine Knight',
        'Charlie Red', 'Cherry Blossom', 'Chloe Cherry', 'Cindy Starfall', 'Cintia Dicker',
        'Clara Trinity', 'ClubStripper', 'Coco', 'Coco Chanel', 'Crystal Jackson',
        'Dakota Skye', 'Dani Daniels', 'Danielle Derek', 'Dasha Taran', 'Dava Foxx',
        'Dee Williams', 'Delta White', 'Demii Lovato', 'Destiny Dixon', 'Devon Jenkin\'s Partner',
        'Diamond Kitty', 'Diamond Rios', 'Diana Daniels', 'Dolly Leigh', 'Dylan Ryder',
        'Eden Sin', 'Elizabeth Bentley', 'Ella Cruz', 'Ella Rodriguez', 'Elsa Jean',
        'Emma Leigh', 'Emma Starletto', 'Eva Notty', 'Evelyn Claire', 'Evelyn Lin',
        'Faye Reagan', 'Ginebra Bellucci', 'Gizelle Blanco', 'Goldie Glock', 'Gwen Diamond',
        'Haley Reed', 'Harlow West', 'Harmony Wonder', 'Hazel Heart', 'Heather Vahn',
        'Helly Mae Hellfire', 'Hollie Mack', 'Holly Michaels', 'Honey Hayes', 'Isla Moon',
        'Ivy Lebelle', 'Jackie Hoff', 'Jada Stevens', 'Jade Dixon', 'Jade Nile',
        'Jasmine Jae', 'Jayla Foxx', 'Jenna Foxx', 'Jenna Sativa', 'Jennifer Best',
        'Jennifer Jane', 'Jeri Ryan', 'Jessie Rogers', 'Jill Kassidy', 'Jimena Lago',
        'Joanna Bliss', 'Jodie Foster\'s Twin', 'Jordana Lopez', 'Joseline Kelly', 'Journey Jax',
        'Julia Ragnarsson', 'Julia Vitols', 'Julie Skyhigh', 'Justine Cross', 'Kaiya Lynn',
        'Kali Rose', 'Kat Dior', 'Katalina Kyle', 'Katrina Jade', 'Katsumi',
        'Kayla Kayden', 'Kaylani Lei', 'Keisha Grey', 'Kelly Collins', 'Kelly Divine',
        'Kenna James', 'Kennedy Leigh', 'Kendra James', 'Kerry King', 'Khloe Kapri',
        'Kiara Cole', 'Kiera King', 'Kira Noir', 'Kleo Foxx', 'Kobe Tai',
        'Kortney Kane', 'Kristen Scott', 'Krystal Boyd', 'Kylie Ireland', 'Kylie Page',
        'Lacie James', 'Lacy Jones', 'Laila Law', 'Lana Violet', 'Lara Lee',
        'Larissa Reis', 'Laura Bentley', 'Lauren Phillips', 'Layla Ray', 'Lea Lexis',
        'Leigh Darby', 'Lena Fire', 'Lexi Luna', 'Lexi Ward', 'Lia Lor',
        'Liliane Tiger', 'Lily Rader', 'Lina Noir', 'Linda Shaw', 'Little Caprice',
        'Liz Vicious', 'Lola Fae', 'Lola Lane', 'London River', 'Lorelei Lee',
        'Louisa Khovanski', 'Lucia Love', 'Lucy Doll', 'Lupe Fuentes', 'Lynda Rae',
        'Mackenzie Mace', 'Macy Cartel', 'Madeline White', 'Maddy Rose', 'Maitresse Madeline',
        'Mandy Flores', 'Marica Hase', 'Marie McCray', 'Marina Visconti', 'Marlie Moore',
        'Mary Carey', 'Mary Moody', 'Maya Bijou', 'Maya Kendrick', 'Megan Sage',
        'Melanie Hicks', 'Melanie Rios', 'Melissa Jacobs', 'Melissa Lynn', 'Mercedes Lynn',
        'Mercedes McNab', 'Mia Austin', 'Mia Li', 'Mia Little', 'Mickey Breeze',
        'Mikayla Miles', 'Mila Azul', 'Mila Jade', 'Miley May', 'Mina Moon',
        'Minori Kawana', 'Misty Stone', 'Mitzi Monroe', 'Miwa', 'Monica Mayhem',
        'Monica Santhiago', 'Monica Sweet', 'Morgan Lee', 'Mya G', 'Mya Mason',
        'Nadia Noir', 'Nadia Styles', 'Naomi Banxx', 'Naomi Blue', 'Natalia Grey',
        'Natalie Brooks', 'Natalie Cox', 'Natalie Mars', 'Nataly Gold', 'Nataly Von',
        'Natasha Dream', 'Natasha Starr', 'Nella Jones', 'Nelly Kent', 'Nena Anderson',
        'Nia Nacci', 'Nickey Huntsman', 'Nicole Clitman', 'Nicole Graves', 'Nicole Ray',
        'Nikki Darlin', 'Nikki Hunter', 'Nikki Kiss', 'Nikki Love', 'Nikki Nova',
        'Nikki Sixx', 'Nikki Sweet', 'Nina Ferrari', 'Nina Novikova', 'Nina Snow',
        'Nirvana', 'Nyomi Banxxx', 'Aaliyah Love', 'Aaliyah Jolie', 'Abigail Mac',
        'Adria Rae', 'Aidra Fox', 'Aiden Ashley', 'Aiko Kaito', 'Aimee London',
        'Ainsley Addison', 'Aisha A', 'Aislin', 'Aissa', 'Aj Applegate',
        'Alaina Dawson', 'Alana Cruise', 'Alana Evans', 'Alani Angel', 'Alanah Rae',
        'Alaska Thunderfuck', 'Alecia Fox', 'Aleksa Nicole', 'Alektra Storm', 'Alena Croft',
        'Aleska Diamond', 'Alexa Aimes', 'Alexa Grace', 'Alexa Tomas', 'Alexa Raye',
        'Alexandra Cat', 'Alexandra Silk', 'Alexi Anders', 'Alexis Amore', 'Alexis Crystal',
        'Alexis Fawx', 'Alexis Monroe', 'Alexis Silver', 'Alexis Texas', 'Alexxa Vice',
        'Alia Janine', 'Alice Chambers', 'Alice in Cradle', 'Alicia Angel', 'Alicia Rhodes',
        'Alicia Stone', 'Alina Li', 'Alina Lopez', 'Alina Rose', 'Alisha Adams',
        'Alisha Klass', 'Alison Star', 'Alissa', 'Allie Haze', 'Allie James',
        'Allie Nicole', 'Allyssa Hall', 'Alyssa Bounty', 'Alyssa Cole', 'Alyssa Lynn',
        'Alyssa Reece', 'Amarna Miller', 'AmateurElle', 'Amber Cherry', 'Amber Hahn',
        'Amber Ivy', 'Amber Leigh', 'Amber Michaels', 'Amber Rayne', 'Amber Snow',
        'Amber Stone', 'Amber Sunshine', 'Amber Sweet', 'Amber Sym', 'Amber Taylor',
        'Ambrosia', 'Amina', 'Amirah Adara', 'Amiya Lee', 'Amouranth',
        'Amy Anderssen', 'Amy Brooke', 'Amy Quinn', 'Ana Foxx', 'Ana Rose',
        'Anabela', 'Anabelle', 'Analyn', 'Anastasia Blue', 'Anastasia Devine',
        'Anastasia Pierce', 'Anastasia Rose', 'Anata', 'Andi James', 'Andi Land',
        'Andie Anderson', 'Andie Valentino', 'Andrea', 'Andrea Diprè', 'Andrea Rosu',
        'Andromeda', 'Aneesa', 'Angel Allure', 'Angel Cummings', 'Angel Dark',
        'Angel Eyes', 'Angel Heart', 'Angel Kelly', 'Angel Long', 'Angel Rain',
        'Angel Smile', 'Angel Storm', 'Angel Valentina', 'Angela Attison', 'Angela Deem',
        'Angela Lee', 'Angela Little', 'Angela Stone', 'Angela Summers', 'Angela Taylor',
        'Angelic Morena', 'Angelica', 'Angelica Heart', 'Angelica Lane', 'Angelica Raven',
        'Angelika', 'Angelina Armani', 'Angelina Ash', 'Angelina Crow', 'Angelina Love',
        'Angelina Rose', 'Angelina Stoli', 'Angelina Valentine', 'Angell Summers', 'Angelz',
        'Anie', 'Anikka', 'Anina Silk', 'Anissa Kate', 'Anita',
        'Anita Blond', 'Anita Dark', 'Anita Pearl', 'Anjelica', 'Anjuli',
        'Anna Bell Peaks', 'Anna Claire Clouds', 'Anna De Ville', 'Anna Lovato', 'Anna Malle',
        'Anna Martinez', 'Anna Nova', 'Anna Ohura', 'Anna Polina', 'Anna Rose',
        'Anna Silk', 'Anna Star', 'Anna Bella', 'Annabelle', 'Annabelle Rogers',
        'Annalise', 'Anne', 'Anne Howe', 'Anneke', 'Annika',
        'Annina Ucatis', 'Anora', 'Anouk', 'Antoinette', 'Antonia',
        'Anya', 'Anya Ivy', 'Anya Olsen', 'Anya Slut', 'Apolonia',
        'April', 'April Flores', 'April Hart', 'April King', 'April May',
        'Aqua', 'Ara', 'Arabella', 'Arabelle Raphael', 'Aria',
        'Aria Carson', 'Aria Lee', 'Aria Night', 'Aria Rossi', 'Aria Sky',
        'Ariana', 'Ariana Marie', 'Ariana Van X', 'Arianna', 'Ariel',
        'Ariel Anderssen', 'Ariel Rebel', 'Ariel X', 'Arisha', 'Arisa',
        'Armani', 'Artemis', 'Arwen', 'Asha', 'Ashanti',
        'Ashlee', 'Ashlee Chambers', 'Ashlee Nicole', 'Ashley Adams', 'Ashley Blue',
        'Ashley Fires', 'Ashley Lane', 'Ashley Long', 'Ashley Marie', 'Ashley Moore',
        'Ashley Nicole', 'Ashley Rae', 'Ashley Renee', 'Ashley Sage', 'Ashley Sinclair',
        'Ashley Steele', 'Ashley Stone', 'Ashley Sweet', 'Ashley Taylor', 'Ashley Violet',
        'Ashlynn', 'Ashlynn Brooke', 'Ashlynn Leigh', 'Asia', 'Asia Moss',
        'Aspen', 'Aspen Brook', 'Aspen Rayne', 'Aspen Valley', 'Asta',
        'Athena', 'Athena Faris', 'Athena Pleasure', 'Athena Rayne', 'Atlanta',
        'Aubrey', 'Aubrey Addams', 'Aubrey Black', 'Aubrey Kate', 'Aubrey Sinclair',
        'Audrey', 'Audrey Allen', 'Audrey Bitoni', 'Audrey Elson', 'Audrey Hollander',
        'Audrey Rose', 'Aurora', 'Aurora Belle', 'Aurora Snow', 'Autumn',
        'Autumn Bliss', 'Autumn Falls', 'Autumn Moon', 'Autumn Rain', 'Autumn Sky',
        'Ava', 'Ava Adams', 'Ava Aurelia', 'Ava Dalush', 'Ava Devine',
        'Ava Kox', 'Ava Rose', 'Ava Taylor', 'Ava Valentino', 'Ava White',
        'Aveline', 'Avery', 'Avery Jane', 'Avery Moore', 'Avril',
        'Axelle', 'Ayesha', 'Azalea', 'Babe', 'Babette',
        'Baby', 'Bailey', 'Bailey Blue', 'Bailey Brooks', 'Bailey Jay',
        'Bambino', 'Bambi', 'Bambi Diamond', 'Barbarella', 'Barbie',
        'Barbie Cupido', 'Barbie Doll', 'Barbie Sins', 'Barrett', 'Baylee',
        'Beata', 'Beatrice', 'Becca', 'Becky', 'Bella',
        'Bella Bliss', 'Bella Bum', 'Bella Luna', 'Bella Marie', 'Bella Milano',
        'Bella Monét', 'Bella Rose', 'Bella Rossi', 'Bella Sera', 'Bella Stone',
        'Belle', 'Belle Claire', 'Belle Noire', 'Berry', 'Bess',
        'Beth', 'Bethany', 'Betsy', 'Bianca', 'Bianca Hill',
        'Bianca Stone', 'Bijou', 'Billie', 'Billie Eilish\'s Twin', 'Billie Star',
        'Billy', 'Birdie', 'Bishop', 'Bizarre', 'Blair',
        'Blake', 'Blake Bartelli', 'Blake Eden', 'Blake Rose', 'Blanche',
        'Blaze', 'Bliss', 'Blondie', 'Blue', 'Blu',
        'Bobbi', 'Bobbi Bliss', 'Bobbi Dylan', 'Bobbi Starr', 'Bobby',
        'Bondi', 'Bonnie', 'Bonnie Day', 'Bonnie Rotten', 'Bossy',
        'Bowie', 'Brandi', 'Brandi Belle', 'Brandi Lyons', 'Brandy',
        'Brandy Aniston', 'Brandy Lee', 'Brandy Love', 'Brandy Talore', 'Brea',
        'Brea Lynn', 'Breauna', 'Bree', 'Bree Daniels', 'Bree Madison',
        'Breeze', 'Brenda', 'Brenda James', 'Brett', 'Briana',
        'Briana Banks', 'Briana Blair', 'Brianna', 'Brianna Beach', 'Brianna Love',
        'Brianna Ray', 'Bridget', 'Bridget B', 'Bridgette', 'Briella',
        'Brigitte', 'Brigitte Lahaie', 'Brin', 'Brinda', 'Bristol',
        'Britney', 'Britney Amber', 'Britney Stevens', 'Brittany', 'Brittany Banxxx',
        'Brittany Bell', 'Brittany Blue', 'Brittany Cox', 'Brittany Jaymes', 'Brittany Lynn',
        'Brittany O\'Neil', 'Brittany Rose', 'Brittney', 'Brittney Skye', 'Brittni',
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
                'gender' => 'female',
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
        $this->command?->info("FemaleAdultStarsSeeder: {$created} created, {$skipped} skipped (out of {$total})");
    }
}
