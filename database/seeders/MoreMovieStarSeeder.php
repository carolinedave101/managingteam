<?php

namespace Database\Seeders;

use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MoreMovieStarSeeder extends Seeder
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
            // Veteran / Classic Hollywood Legends (25)
            ['name' => 'Morgan Freeman', 'bio' => 'Oscar-winning narrator and actor with one of the most recognizable voices in film history. Known for The Shawshank Redemption, Driving Miss Daisy (Oscar nomination), Million Dollar Baby (Oscar win), Se7en, and Batman Begins.'],
            ['name' => 'Anthony Hopkins', 'bio' => 'Legendary actor and two-time Oscar winner known for The Silence of the Lambs (Academy Award for Best Actor), The Father (Oscar win), Hannibal, Westworld, and The Remains of the Day. One of the greatest living actors.'],
            ['name' => 'Harrison Ford', 'bio' => 'Iconic American actor known for playing Indiana Jones and Han Solo in two of the biggest franchises in cinema history. Also known for Blade Runner, The Fugitive, and Patriot Games. A true Hollywood legend.'],
            ['name' => 'Al Pacino', 'bio' => 'Oscar-winning actor and method acting legend known for The Godfather trilogy, Scarface, Scent of a Woman (Academy Award for Best Actor), Heat, Dog Day Afternoon, and The Irishman.'],
            ['name' => 'Robert De Niro', 'bio' => 'Two-time Oscar-winning actor and co-founder of the Tribeca Film Festival. Known for The Godfather Part II, Taxi Driver, Raging Bull (Oscar win), Goodfellas, The Deer Hunter, and Heat.'],
            ['name' => 'Michael Douglas', 'bio' => 'Oscar-winning actor and producer known for Wall Street (Academy Award for Best Actor), Fatal Attraction, Basic Instinct, The American President, and the Ant-Man franchise. Son of Kirk Douglas.'],
            ['name' => 'Sylvester Stallone', 'bio' => 'Iconic action star and Oscar-nominated screenwriter known for creating and starring in the Rocky and Rambo franchises. Also known for The Expendables, Creed (Oscar nomination), and Cliffhanger.'],
            ['name' => 'Arnold Schwarzenegger', 'bio' => 'Bodybuilding champion turned Hollywood megastar and former Governor of California. Known for The Terminator franchise, Predator, Total Recall, True Lies, and Conan the Barbarian.'],
            ['name' => 'John Travolta', 'bio' => 'Oscar-nominated actor known for his iconic roles in Saturday Night Fever, Grease, Pulp Fiction (Oscar nomination), Face/Off, Get Shorty, and Phenomenon. A defining star of the 70s and 90s.'],
            ['name' => 'Danny DeVito', 'bio' => 'Beloved actor, director, and producer known for Taxi (Emmy win), Twins, Matilda, Batman Returns, It\'s Always Sunny in Philadelphia, and One Flew Over the Cuckoo\'s Nest. A Hollywood icon.'],
            ['name' => 'Christopher Walken', 'bio' => 'Oscar-winning actor known for his unique delivery and presence. Known for The Deer Hunter (Academy Award for Best Supporting Actor), Pulp Fiction, Catch Me If You Can, and Saturday Night Live appearances.'],
            ['name' => 'James Woods', 'bio' => 'Oscar-nominated actor and two-time Emmy winner known for Salvador, Ghosts of Mississippi, Videodrome, Casino, Hercules (voice of Hades), and the TV series Shark. Known for his intense performances.'],
            ['name' => 'Martin Sheen', 'bio' => 'Acclaimed actor known for Apocalypse Now, The West Wing (Golden Globe win for President Josiah Bartlet), Badlands, and The Departed. Father of Charlie Sheen and activist.'],
            ['name' => 'Jon Voight', 'bio' => 'Oscar-winning actor known for Midnight Cowboy (Oscar nomination), Coming Home (Academy Award for Best Actor), Deliverance, Mission: Impossible, Heat, and the Ray Donovan TV series.'],
            ['name' => 'Danny Glover', 'bio' => 'Acclaimed actor and activist known for the Lethal Weapon franchise (Detective Roger Murtaugh), The Color Purple, Dreamgirls, Predator 2, and Angels in the Outfield. Also a UNICEF ambassador.'],
            ['name' => 'Christopher Lloyd', 'bio' => 'Emmy-winning actor known for Back to the Future (Doc Brown), Taxi (Emmy win), The Addams Family (Uncle Fester), Who Framed Roger Rabbit, and One Flew Over the Cuckoo\'s Nest.'],
            ['name' => 'Michael J. Fox', 'bio' => 'Emmy and Golden Globe-winning actor known for Back to the Future trilogy, Family Ties, Spin City, and Teen Wolf. A prominent advocate for Parkinson\'s disease research through his foundation.'],
            ['name' => 'Alec Baldwin', 'bio' => 'Emmy and Golden Globe-winning actor known for 30 Rock (Emmy win), The Hunt for Red October, Glengarry Glen Ross, The Departed, Beetlejuice, and his iconic Saturday Night Live Trump impressions.'],
            ['name' => 'Jeremy Irons', 'bio' => 'Oscar and Emmy-winning British actor known for Reversal of Fortune (Academy Award for Best Actor), The Lion King (voice of Scar), Die Hard with a Vengeance, House of Gucci, and Watchmen.'],
            ['name' => 'Andy Garcia', 'bio' => 'Oscar-nominated Cuban-American actor known for The Godfather Part III, The Untouchables, Ocean\'s Eleven franchise, When a Man Loves a Woman, and the Father of the Bride films.'],
            ['name' => 'Steve Buscemi', 'bio' => 'Distinctive character actor and director known for Reservoir Dogs, Fargo, The Big Lebowski, Boardwalk Empire (Emmy win), Con Air, and Armageddon. Also a volunteer firefighter.'],
            ['name' => 'John Goodman', 'bio' => 'Beloved character actor known for Roseanne (Emmy win), The Big Lebowski, Monsters Inc. (Sulley), 10 Cloverfield Lane, Argo, The Flintstones, and the Coen Brothers\' films.'],
            ['name' => 'Gary Oldman', 'bio' => 'Oscar-winning British chameleon actor known for The Darkest Hour (Academy Award for Best Actor), The Dark Knight trilogy (Commissioner Gordon), Leon The Professional, Harry Potter (Sirius Black), and Tinker Tailor Soldier Spy.'],
            ['name' => 'Liam Neeson', 'bio' => 'Oscar-nominated Irish actor who reinvented himself as an action star. Known for Schindler\'s List (Oscar nomination), Taken franchise, The Grey, Batman Begins, Star Wars Episode I, and Michael Collins.'],
            ['name' => 'Ralph Fiennes', 'bio' => 'Oscar-nominated British actor known for Schindler\'s List (Oscar nomination), The English Patient, the Harry Potter franchise (Lord Voldemort), The Grand Budapest Hotel, and The Menu.'],
            // British & International A-List (25)
            ['name' => 'Daniel Craig', 'bio' => 'British actor best known for playing James Bond in five films (Casino Royale through No Time to Die). Also known for Knives Out, The Girl with the Dragon Tattoo, Layer Cake, and Munich.'],
            ['name' => 'Pierce Brosnan', 'bio' => 'Irish actor best known for playing James Bond in four films (GoldenEye through Die Another Day). Also known for Remington Steele, Mrs. Doubtfire, The Thomas Crown Affair, and Mamma Mia!'],
            ['name' => 'Idris Elba', 'bio' => 'British actor and producer known for The Wire (Stringer Bell), Luther (Golden Globe win), Mandela: Long Walk to Freedom, Pacific Rim, The Suicide Squad, and the Thor franchise (Heimdall).'],
            ['name' => 'James McAvoy', 'bio' => 'Scottish actor known for playing Professor X in the X-Men franchise, Atonement (Golden Globe nomination), Split / Glass, The Last King of Scotland, and the Narnia films (Mr. Tumnus).'],
            ['name' => 'Michael Fassbender', 'bio' => 'German-Irish actor known for portraying Magneto in the X-Men franchise, Inglourious Basterds, 12 Years a Slave (Oscar nomination), Steve Jobs (Oscar nomination), Prometheus, and Shame. Also a race car driver.'],
            ['name' => 'Ewan McGregor', 'bio' => 'Scottish actor known for Trainspotting, Star Wars prequels (Obi-Wan Kenobi), Moulin Rouge! (Golden Globe win), Fargo (TV series), and Birds of Prey. Also known for his motorcycle travel documentaries.'],
            ['name' => 'Colin Farrell', 'bio' => 'Irish actor known for In Bruges (Golden Globe win), The Batman (Penguin), The Lobster, The Banshees of Inisherin, Minority Report, Phone Booth, and True Detective season 2.'],
            ['name' => 'Cillian Murphy', 'bio' => 'Irish actor known for Peaky Blinders (Tommy Shelby), Oppenheimer (Academy Award for Best Actor), Inception, 28 Days Later, The Dark Knight trilogy (Scarecrow), and Dunkirk.'],
            ['name' => 'Daniel Day-Lewis', 'bio' => 'Three-time Oscar-winning actor widely regarded as the greatest living actor. Known for My Left Foot (Oscar win), There Will Be Blood (Oscar win), Lincoln (Oscar win), and In the Name of the Father. Retired from acting.'],
            ['name' => 'Hugh Grant', 'bio' => 'Charming British actor known for Four Weddings and a Funeral (Golden Globe win), Notting Hill, Bridget Jones\'s Diary, Love Actually, and more recently The Undoing and Dungeons & Dragons.'],
            ['name' => 'Colin Firth', 'bio' => 'Oscar-winning British actor known for The King\'s Speech (Academy Award for Best Actor), Bridget Jones\'s Diary, Pride and Prejudice (Mr. Darcy), A Single Man (Oscar nomination), and Kingsman.'],
            ['name' => 'Tom Hiddleston', 'bio' => 'British actor known for playing Loki in the Marvel Cinematic Universe, The Night Manager (Golden Globe win / Emmy nomination), Crimson Peak, Kong Skull Island, and Henry IV / Henry V at the RSC.'],
            ['name' => 'Benedict Cumberbatch', 'bio' => 'British actor known for Sherlock (Emmy win), Doctor Strange in the MCU, The Imitation Game (Oscar nomination), The Power of the Dog (Oscar nomination), and Star Trek Into Darkness.'],
            ['name' => 'Eddie Redmayne', 'bio' => 'Oscar-winning British actor known for The Theory of Everything (Academy Award for Best Actor), Fantastic Beasts franchise (Newt Scamander), Les Miserables, The Danish Girl (Oscar nomination), and The Good Nurse.'],
            ['name' => 'Henry Cavill', 'bio' => 'British actor known for playing Superman in the DCEU, Geralt of Rivia in The Witcher, Superman: Man of Steel, Mission: Impossible Fallout, and Enola Holmes. Also an avid PC builder.'],
            ['name' => 'Orlando Bloom', 'bio' => 'British actor known for Legolas in The Lord of the Rings and The Hobbit trilogies, Will Turner in the Pirates of the Caribbean franchise, Troy, and Elizabethtown.'],
            ['name' => 'Jude Law', 'bio' => 'Oscar-nominated British actor known for The Talented Mr. Ripley (Oscar nomination), Cold Mountain, Sherlock Holmes (Dr. Watson), The Holiday, Fantastic Beasts (Dumbledore), and Road to Perdition.'],
            ['name' => 'Clive Owen', 'bio' => 'Oscar-nominated British actor known for Closer (Oscar nomination), Children of Men, Sin City, Inside Man, The Knick (Golden Globe win), and Elizabeth: The Golden Age.'],
            ['name' => 'Jason Statham', 'bio' => 'British action star and former Olympic diver known for The Transporter franchise, Crank, The Expendables, Fast & Furious franchise, The Meg, and Snatch. Famous for his no-nonsense tough guy roles.'],
            ['name' => 'Sean Bean', 'bio' => 'British actor known for Game of Thrones (Ned Stark), The Lord of the Rings (Boromir), Sharpe, Patriot Games, GoldenEye (006), and Troy. Infamous for his characters dying on screen.'],
            ['name' => 'Dominic West', 'bio' => 'British actor known for The Wire (Jimmy McNulty), The Affair (Golden Globe win), The Crown (Prince Charles), Chicago (Roxie\'s husband), and 300. An acclaimed stage actor.'],
            ['name' => 'Charlie Hunnam', 'bio' => 'British actor known for Sons of Anarchy (Jax Teller), Pacific Rim, King Arthur: Legend of the Sword, The Gentlemen, and Queer as Folk (UK). Known for his gruff leading man presence.'],
            ['name' => 'Theo James', 'bio' => 'British actor known for the Divergent Series (Four), The White Lotus season 2, Underworld: Awakening, How It Ends, and the TV series Sanditon. Also a musician.'],
            ['name' => 'Jamie Dornan', 'bio' => 'British actor known for the Fifty Shades of Grey franchise (Christian Grey), The Fall, Belfast, A Haunting in Venice, and The Tourist. Began his career as a Calvin Klein model.'],
            ['name' => 'Kit Harington', 'bio' => 'British actor known for playing Jon Snow in Game of Thrones (Emmy nomination), Pompeii, The Death of Stalin, and the Marvel Cinematic Universe (Dane Whitman / Black Knight in Eternals).'],
            // More American Stars (25)
            ['name' => 'Joaquin Phoenix', 'bio' => 'Oscar-winning actor known for Joker (Academy Award for Best Actor), Walk the Line (Oscar nomination), Gladiator, Her, The Master, Signs, and Beau Is Afraid. One of the most intense actors of his generation.'],
            ['name' => 'Javier Bardem', 'bio' => 'Oscar-winning Spanish actor known for No Country for Old Men (Academy Award for Best Supporting Actor), Skyfall, Biutiful (Oscar nomination), Vicky Cristina Barcelona, Dune, and Being the Ricardos.'],
            ['name' => 'Benicio Del Toro', 'bio' => 'Oscar-winning Puerto Rican actor known for Traffic (Academy Award for Best Supporting Actor), Sicario, The Usual Suspects, Fear and Loathing in Las Vegas, Star Wars: The Last Jedi, and Guardians of the Galaxy.'],
            ['name' => 'Christoph Waltz', 'bio' => 'Two-time Oscar-winning Austrian actor known for Inglourious Basterds (Oscar win), Django Unchained (Oscar win), Spectre, Alita: Battle Angel, The Green Hornet, and Water for Elephants.'],
            ['name' => 'Stanley Tucci', 'bio' => 'Oscar-nominated actor, writer, and producer known for The Devil Wears Prada, The Lovely Bones (Oscar nomination), Spotlight, The Hunger Games franchise, Julie & Julia, and his travel food shows.'],
            ['name' => 'Sam Rockwell', 'bio' => 'Oscar-winning actor known for Three Billboards Outside Ebbing, Missouri (Academy Award for Best Supporting Actor), Moon, The Green Mile, Iron Man 2, Jojo Rabbit, The Way Way Back, and Vice.'],
            ['name' => 'Cuba Gooding Jr.', 'bio' => 'Oscar-winning actor known for Jerry Maguire (Academy Award for Best Supporting Actor), Boyz n the Hood, A Few Good Men, As Good as It Gets, Pearl Harbor, and Radio.'],
            ['name' => 'Terrence Howard', 'bio' => 'Oscar-nominated actor known for Hustle & Flow (Oscar nomination), Crash, Iron Man (Rhodey), August Wilson\'s Fences, and the TV series Empire (Lucious Lyon). Also a singer.'],
            ['name' => 'Forest Whitaker', 'bio' => 'Oscar-winning actor and director known for The Last King of Scotland (Academy Award for Best Actor), Bird, Ghost Dog: The Way of the Samurai, The Butler, Black Panther (Zuri), and Rogue One.'],
            ['name' => 'Laurence Fishburne', 'bio' => 'Oscar-nominated actor known for The Matrix trilogy (Morpheus), Apocalypse Now, Boyz n the Hood, What\'s Love Got to Do with It (Oscar nomination), CSI: Crime Scene Investigation, and John Wick.'],
            ['name' => 'Djimon Hounsou', 'bio' => 'Two-time Oscar-nominated Beninese actor known for Amistad, Gladiator, In America (Oscar nomination), Blood Diamond (Oscar nomination), Guardians of the Galaxy (Korath), and Shazam!'],
            ['name' => 'Ken Watanabe', 'bio' => 'Oscar-nominated Japanese actor known for The Last Samurai (Oscar nomination), Inception, Batman Begins, Godzilla (2014) and Godzilla vs Kong, Letters from Iwo Jima, and Memoirs of a Geisha.'],
            ['name' => 'Hiroyuki Sanada', 'bio' => 'Veteran Japanese actor known for The Last Samurai, John Wick 4, Mortal Kombat (Scorpion), Avengers: Endgame, 47 Ronin, Westworld, Shogun (Emmy win), and Bullet Train.'],
            ['name' => 'John Turturro', 'bio' => 'Acclaimed character actor known for Barton Fink (Cannes award), The Big Lebowski (Jesus), Do the Right Thing, O Brother Where Art Thou, Transformers franchise, and the TV series The Night Of.'],
            ['name' => 'Ethan Hawke', 'bio' => 'Oscar-nominated actor, writer, and director known for Training Day (Oscar nomination), Before Sunrise/Sunset/Midnight trilogy, Dead Poets Society, Boyhood (Oscar nomination), and Moon Knight.'],
            ['name' => 'Pedro Pascal', 'bio' => 'Chilean-American actor who became a global star through Game of Thrones (Oberyn Martell), Narcos (Pablo Escobar), The Mandalorian (Din Djarin), The Last of Us (Joel), and The Wonder Woman 1984.'],
            ['name' => 'Oscar Isaac', 'bio' => 'Guatemalan-American actor known for Ex Machina, Star Wars sequels (Poe Dameron), Dune, Inside Llewyn Davis (Golden Globe win), Moon Knight, and Show Me a Hero (Emmy nomination).'],
            ['name' => 'Diego Luna', 'bio' => 'Mexican actor and director known for Y Tu Mamá También, the Star Wars franchise (Cassian Andor in Rogue One / Andor), The Terminal, Narcos: Mexico, and The Book of Life.'],
            ['name' => 'Gael García Bernal', 'bio' => 'Mexican actor and producer known for Y Tu Mamá También, The Motorcycle Diaries, Babel, Amores Perros, Coco (voice), Mozart in the Jungle (Golden Globe win), and Old.'],
            ['name' => 'Demián Bichir', 'bio' => 'Oscar-nominated Mexican actor known for A Better Life (Oscar nomination), The Hateful Eight, The Nun, Alien: Covenant, Che, Grand Hotel, and the TV series Weeds.'],
            ['name' => 'Wagner Moura', 'bio' => 'Brazilian actor and director known for playing Pablo Escobar in Narcos, Elite Squad, Elysium, Civil War, The Gray Man, and the Brazilian film Tropa de Elite.'],
            ['name' => 'Kevin Costner', 'bio' => 'Oscar-winning actor and director known for Dances with Wolves (Academy Award for Best Director), The Bodyguard, Field of Dreams, Robin Hood: Prince of Thieves, Yellowstone, and Horizon.'],
            ['name' => 'Tommy Lee Jones', 'bio' => 'Oscar-winning actor known for The Fugitive (Academy Award for Best Supporting Actor), Men in Black franchise, No Country for Old Men, Lincoln, and the TV series The Amazing Howard Hughes.'],
            ['name' => 'Dennis Quaid', 'bio' => 'Veteran actor known for The Parent Trap, The Rookie, The Day After Tomorrow, Frequency, Great Balls of Fire (Jerry Lee Lewis), Innerspace, and the TV series Goliath.'],
            ['name' => 'Sam Elliott', 'bio' => 'Oscar-nominated actor with his iconic deep voice and mustache. Known for A Star Is Born (Oscar nomination), The Big Lebowski (The Stranger), Tombstone, Road House, Yellowstone prequels, and The Hero.'],
            // TV Stars & Character Actors (25)
            ['name' => 'Jon Hamm', 'bio' => 'Emmy and Golden Globe-winning actor known for Mad Men (Don Draper), The Town, Baby Driver, Top Gun: Maverick, Bridgerton, Fargo, and The Morning Show. One of the finest dramatic actors of his generation.'],
            ['name' => 'Bob Odenkirk', 'bio' => 'Emmy-winning actor, writer, and comedian known for Better Call Saul (Saul Goodman / Jimmy McGill), Breaking Bad, Mr. Show, Nobody, and The Post. A master of both comedy and drama.'],
            ['name' => 'Aaron Paul', 'bio' => 'Three-time Emmy-winning actor known for Breaking Bad (Jesse Pinkman), El Camino, BoJack Horseman (Todd Chavez), The Path, and Westworld. Also a producer on several projects.'],
            ['name' => 'Walton Goggins', 'bio' => 'Distinctive character actor known for The Shield (Shane Vendrell), Justified (Boyd Crowder), The Hateful Eight, Django Unchained, Fallout (The Ghoul), and Vice Principals.'],
            ['name' => 'Jon Bernthal', 'bio' => 'Intense actor known for The Walking Dead (Shane Walsh), The Punisher / Daredevil (Frank Castle), The Accountant, Baby Driver, The Bear, and Ford v Ferrari.'],
            ['name' => 'Jeffrey Dean Morgan', 'bio' => 'Actor known for The Walking Dead (Negan), Supernatural (John Winchester), Grey\'s Anatomy (Denny Duquette), Watchmen (The Comedian), Red Dawn, and The Boys.'],
            ['name' => 'Jensen Ackles', 'bio' => 'Actor known for Supernatural (Dean Winchester) for 15 seasons, The Boys (Soldier Boy), My Bloody Valentine 3D, Dark Angel, and voice acting in Red Dead Redemption and Batman: Under the Red Hood.'],
            ['name' => 'Jared Padalecki', 'bio' => 'Actor known for Supernatural (Sam Winchester) for 15 seasons, Gilmore Girls (Dean Forester), Friday the 13th (2009), House of Wax, and Walker (which he also executive produces).'],
            ['name' => 'Norman Reedus', 'bio' => 'Actor and model known for The Walking Dead (Daryl Dixon), The Boondock Saints, Blade II, Death Stranding (video game lead), and Ride with Norman Reedus travel show.'],
            ['name' => 'Andrew Lincoln', 'bio' => 'British actor known for playing Rick Grimes in The Walking Dead for 9 seasons, Love Actually, Teachers, Afterlife, and the upcoming Walking Dead movies. Also a theatre director.'],
            ['name' => 'Peter Dinklage', 'bio' => 'Emmy and Golden Globe-winning actor known for Game of Thrones (Tyrion Lannister), The Station Agent, Elf, The Avengers: Infinity War, Three Billboards, The Hunger Games prequel, and Cyrano.'],
            ['name' => 'Nikolaj Coster-Waldau', 'bio' => 'Danish actor known for Game of Thrones (Jaime Lannister), Oblivion, The Last Vermeer, Mama, Gods of Egypt, and the Danish film The Night Watch. Also a producer.'],
            ['name' => 'Charlie Cox', 'bio' => 'British actor known for playing Daredevil / Matt Murdock in the Netflix Marvel series and She-Hulk, Boardwalk Empire, The Theory of Everything, Stardust, and The King\'s Man.'],
            ['name' => 'Neil Patrick Harris', 'bio' => 'Emmy-winning actor, singer, and magician known for How I Met Your Mother (Barney Stinson), Doogie Howser MD, Dr. Horrible\'s Sing-Along Blog, A Series of Unfortunate Events, and Hedwig on Broadway.'],
            ['name' => 'Matt Smith', 'bio' => 'British actor known for playing the Eleventh Doctor in Doctor Who, Prince Philip in The Crown (Emmy nomination), House of the Dragon (Daemon Targaryen), and Morbius.'],
            ['name' => 'David Tennant', 'bio' => 'Emmy-winning Scottish actor known for playing the Tenth Doctor in Doctor Who, Kilgrave in Jessica Jones, Crowley in Good Omens, Des, Around the World in 80 Days, and Broadchurch.'],
            ['name' => 'Zachary Levi', 'bio' => 'Actor known for playing Shazam in the DC franchise, Chuck (Chuck Bartowski), Tangled (voice of Flynn Rider), Alvin and the Chipmunks, and The CW\'s Heroes Reborn.'],
            ['name' => 'Nathan Fillion', 'bio' => 'Canadian actor known for Firefly / Serenity (Captain Mal), Castle (Richard Castle), The Rookie, Castle, Dr. Horrible\'s Sing-Along Blog, and voice acting in Halo and Destiny.'],
            ['name' => 'Alan Tudyk', 'bio' => 'Versatile character actor known for Firefly (Wash), Rogue One (K-2SO), Suburgatory, Resident Alien, Doom Patrol, Frozen (voice), Moana (voice of Heihei), and Harley Quinn.'],
            ['name' => 'Bruce Campbell', 'bio' => 'Cult icon known for The Evil Dead franchise (Ash Williams), Army of Darkness, Burn Notice, Bubba Ho-Tep, Spider-Man trilogy (Sam Raimi), and voice acting in Disney productions.'],
            ['name' => 'Tom Ellis', 'bio' => 'British actor known for playing Lucifer Morningstar in Lucifer for 6 seasons, Miranda, Monday Monday, The Fades, Rush, and the BBC drama EastEnders. Also a classically trained musician.'],
            ['name' => 'Ed Harris', 'bio' => 'Four-time Oscar-nominated actor known for Apollo 13, The Truman Show, Pollock (Oscar nomination), The Rock, Westworld (Man in Black), A Beautiful Mind, and The Right Stuff.'],
            ['name' => 'William H. Macy', 'bio' => 'Oscar-nominated actor and two-time Emmy winner known for Shameless (Frank Gallagher), Fargo (film), Magnolia, Boogie Nights, Jurassic Park III, and The Cooler (Oscar nomination).'],
            ['name' => 'Tim Blake Nelson', 'bio' => 'Character actor known for O Brother Where Art Thou (Delmar), The Ballad of Buster Scruggs, Watchmen (Wade Tillman / Looking Glass), The Incredible Hulk (Samuel Sterns), and Dune.'],
            ['name' => 'Giancarlo Esposito', 'bio' => 'Acclaimed actor known for Breaking Bad / Better Call Saul (Gus Fring), The Mandalorian (Moff Gideon), The Boys (Stan Edgar), Do the Right Thing, Malcolm X, Training Day, and Rabbit Hole. An icon of modern television.'],
            // Young & Rising Stars (16)
            ['name' => 'Jacob Elordi', 'bio' => 'Australian rising star known for Euphoria (Nate Jacobs), The Kissing Booth franchise, Priscilla (Elvis Presley), Saltburn, and Deep Water. One of the most sought-after young actors in Hollywood.'],
            ['name' => 'Paul Mescal', 'bio' => 'Irish rising star known for Normal People (Emmy nomination), Aftersun (Oscar nomination), All of Us Strangers, Gladiator II, and The Lost Daughter. Also a stage actor and musician.'],
            ['name' => 'Jeremy Allen White', 'bio' => 'Emmy-winning actor known for Shameless (Lip Gallagher), The Bear (Carmy Berzatto) — winning multiple Emmys and Golden Globes, and the upcoming Bruce Springsteen biopic.'],
            ['name' => 'Joe Keery', 'bio' => 'American actor and musician known for Stranger Things (Steve Harrington), Free Guy, Fargo season 5, and his solo music project Djo (with hit single "End of Beginning").'],
            ['name' => 'Noah Centineo', 'bio' => 'American actor known for To All the Boys I\'ve Loved Before franchise, The Recruit (Netflix series), Sierra Burgess Is a Loser, Charlie\'s Angels, and Black Adam.'],
            ['name' => 'Dylan O\'Brien', 'bio' => 'American actor known for Teen Wolf (Stiles Stilinski), The Maze Runner trilogy, American Assassin, Love and Monsters, The Outfit, and Not Okay. Also a filmmaker and musician.'],
            ['name' => 'Logan Lerman', 'bio' => 'American actor known for Percy Jackson film series, The Perks of Being a Wallflower, 3:10 to Yuma, Fury, Noah, The Lottery, and the TV series Hunters.'],
            ['name' => 'Nick Robinson', 'bio' => 'American actor known for Love Simon, Jurassic World, The Kings of Summer, Everything Everything, the TV series A Teacher, and Maid.'],
            ['name' => 'Cole Sprouse', 'bio' => 'American actor known for The Suite Life of Zack & Cody (with twin brother Dylan), Riverdale (Jughead Jones), Five Feet Apart, and Moonshot. Also a published photographer.'],
            ['name' => 'Finn Wolfhard', 'bio' => 'Canadian actor and musician known for Stranger Things (Mike Wheeler), the It films (Richie Tozier), The Addams Family (voice of Wednesday), Ghostbusters: Afterlife, and lead singer of The Aubreys.'],
            ['name' => 'Jaeden Martell', 'bio' => 'American actor known for It films (Bill Denbrough), Knives Out, The Defenders, St. Vincent, Midnight Special, The Book of Henry, and the TV series Defending Jacob.'],
            ['name' => 'Jack Champion', 'bio' => 'American rising star known for Avatar: The Way of Water (Spider), Scream VI, The Retaliators, and the upcoming Avatar sequels. One of the youngest actors in major franchises.'],
            ['name' => 'Caleb McLaughlin', 'bio' => 'American actor known for Stranger Things (Lucas Sinclair), Concrete Cowboy, The New Edition Story, and the Broadway musical The Lion King (young Simba).'],
            ['name' => 'Xolo Maridueña', 'bio' => 'American actor known for Cobra Kai (Miguel Diaz), Blue Beetle in the DC Universe, Parenthood, and the animated series Victor and Valentino.'],
            ['name' => 'Rudy Pankow', 'bio' => 'American actor known for Outer Banks (JJ Maybank), Northern Rescue, Hollywood Stargirl, and the upcoming film The Crusade.'],
            ['name' => 'Chase Stokes', 'bio' => 'American actor known for Outer Banks (John B Routledge), Tell Me Lies, Dr. Bird\'s Advice for Sad Poets, and the upcoming Netflix thriller Uglies.'],
            // More Character Actors (15)
            ['name' => 'Clancy Brown', 'bio' => 'Prolific character actor with his distinctive deep voice. Known for The Shawshank Redemption (Captain Hadley), Highlander (The Kurgan), SpongeBob (Mr. Krabs), John Wick 4, and Detroiter.'],
            ['name' => 'Ron Perlman', 'bio' => 'Distinctive actor known for Sons of Anarchy (Clay Morrow), Hellboy franchise, Pacific Rim, Blade II, The Name of the Rose, and the voice of The Lich King in Warcraft.'],
            ['name' => 'Keith David', 'bio' => 'Emmy-winning actor with an iconic voice. Known for John Carpenter\'s The Thing, They Live, Platoon, The Princess and the Frog, Community, and voice roles in Rick and Morty and Gargoyles.'],
            ['name' => 'Lance Henriksen', 'bio' => 'Veteran character actor known for Aliens (Bishop), The Terminator, Millennium (TV series), Pumpkinhead, Aliens vs Predator, and the voice acting in Mass Effect and Fallout.'],
            ['name' => 'Ian McKellen', 'bio' => 'Legendary British actor known for Gandalf in The Lord of the Rings / The Hobbit trilogies and Magneto in the X-Men franchise. Also a celebrated stage actor with Olivier and Tony awards.'],
            ['name' => 'Patrick Stewart', 'bio' => 'Legendary British actor known for playing Captain Picard in Star Trek: The Next Generation, Professor X in the X-Men franchise, and his acclaimed stage career with the RSC.'],
            ['name' => 'John Rhys-Davies', 'bio' => 'Welsh actor known for Gimli in The Lord of the Rings trilogy and Sallah in the Indiana Jones franchise. Also known for The Sliders TV series.'],
            ['name' => 'Karl Urban', 'bio' => 'New Zealand actor known for The Lord of the Rings (Eomer), Star Trek (Bones McCoy), The Boys (Billy Butcher), Dredd (Judge Dredd), and Thor: Ragnarok (Skurge).'],
            ['name' => 'Alan Ritchson', 'bio' => 'American actor known for playing Jack Reacher in the Reacher TV series, Aquaman / Hawk in Smallville and Titans, Blue Mountain State (Thad Castle), and The Hunger Games: Catching Fire.'],
            ['name' => 'Stephen Amell', 'bio' => 'Canadian actor best known for playing Oliver Queen / Green Arrow in Arrow for 8 seasons, The Flash (crossover events), Heels (Jack Spade), and Teenage Mutant Ninja Turtles: Out of the Shadows (Casey Jones).'],
            ['name' => 'Grant Gustin', 'bio' => 'American actor known for playing Barry Allen / The Flash in the CW\'s The Flash for 9 seasons, Glee, Arrow crossover events, and the film Affluenza.'],
            ['name' => 'Tyler Hoechlin', 'bio' => 'American actor known for playing Superman / Clark Kent in Superman & Lois, Teen Wolf (Derek Hale), 7th Heaven, Everybody Wants Some!!, and The Texas Chainsaw Massacre prequel.'],
            ['name' => 'Brandon Routh', 'bio' => 'American actor known for playing Superman in Superman Returns and Ray Palmer / The Atom in Arrow, The Flash, DC\'s Legends of Tomorrow, and the film Scott Pilgrim vs. the World.'],
            ['name' => 'Tom Welling', 'bio' => 'American actor known for playing Clark Kent in Smallville for 10 seasons, Lucifer (Marcus Pierce / Cain), Cheaper by the Dozen films, and the TV series Hellcats.'],
            ['name' => 'Justin Hartley', 'bio' => 'American actor known for This Is Us (Kevin Pearson), Smallville (Green Arrow / Oliver Queen), The Young and the Restless (Emmy win), and the Netflix thriller The Noel Diary.'],
        ];

        foreach ($actors as $i => $actor) {
            $this->createCelebrity($admin, $actor, $i);
        }

        $this->command?->info('Seeded '.count($actors).' additional movie star celebrities!');
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
                'category' => 'movie_star',
                'avatar' => Celebrity::avatarUrlFor($name),
                'cover_photo' => Celebrity::coverUrlFor($slug),
                'gender' => 'male',
                'country' => 'United States',
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
