<?php

namespace Database\Seeders;

class DutchCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Daan', 'Sem', 'Lukas', 'Jesse', 'Thomas',
        'Tim', 'Ruben', 'Max', 'Levi', 'Finn',
        'Thijs', 'Lars', 'Sander', 'Dirk', 'Pieter',
        'Jan', 'Willem', 'Hendrik', 'Kees', 'Bram',
        'Gijs', 'Michiel', 'Jasper', 'Martijn', 'Wouter',
        'Stefan', 'Mark', 'Niels', 'Bas', 'Sjoerd',
        'Jeroen', 'Peter', 'Erik', 'Henk', 'Joost',
        'Maarten', 'Remco', 'Bart', 'Arnoud', 'Gerard',
        'Karel', 'Wim', 'Freek', 'Guus', 'Hugo',
        'Job', 'Koen', 'Pim', 'Roel', 'Teun',
        'Arjen', 'Coen', 'Dennis', 'Frank', 'Harry',
        'Ivo', 'Jaap', 'Lex', 'Menno', 'Olaf',
        'Piet', 'Quirijn', 'Rob', 'Simon', 'Tom',
        'Victor', 'Ward', 'Yorick', 'Aart', 'Ben',
        'Cornelis', 'Ewoud', 'Floris', 'Geert', 'Herman',
        'Jacob', 'Klaas', 'Luuk', 'Noud', 'Oscar',
    ];

    private array $femaleFirstNames = [
        'Emma', 'Anna', 'Lisa', 'Lotte', 'Eva',
        'Sophie', 'Sanne', 'Noa', 'Feline', 'Mila',
        'Roos', 'Lieke', 'Sara', 'Tess', 'Milou',
        'Fenna', 'Britt', 'Laura', 'Julia', 'Linda',
        'Maria', 'Petra', 'Johanna', 'Elisabeth', 'Cornelia',
        'Alida', 'Antje', 'Beatrix', 'Catharina', 'Dirkje',
        'Elsje', 'Femke', 'Greetje', 'Hendrika', 'Ineke',
        'Joke', 'Katrien', 'Lena', 'Marjolein', 'Nelleke',
        'Otto', 'Pietje', 'Renske', 'Truus', 'Wilma',
        'Yvonne', 'Adriana', 'Bianca', 'Claudia', 'Deborah',
        'Esmee', 'Floor', 'Greta', 'Helma', 'Isabel',
        'Jantine', 'Karlijn', 'Liesbeth', 'Mirjam', 'Nadine',
        'Odette', 'Paulien', 'Renate', 'Silvia', 'Tineke',
        'Ulrike', 'Vivian', 'Willeke', 'Xandra', 'Zwaan',
        'Aukje', 'Bo', 'Charlotte', 'Danique', 'Esther',
        'Fleur', 'Hanna', 'Ilse', 'Jolien', 'Kim',
    ];

    private array $lastNames = [
        'de Jong', 'Jansen', 'de Vries', 'van den Berg', 'van Dijk',
        'Bakker', 'Visser', 'Smit', 'Meijer', 'de Boer',
        'Mulder', 'Bos', 'Vos', 'Peters', 'Hendriks',
        'van Leeuwen', 'Dekker', 'Brouwer', 'de Wit', 'Dijkstra',
        'Smits', 'de Graaf', 'van der Veen', 'van der Heiden', 'Jacobs',
        'van der Wal', 'Kuiper', 'Vermeulen', 'van Dam', 'Prins',
        'Kok', 'Kuipers', 'van Beek', 'van der Meer', 'de Bruijn',
        'Scholten', 'Willems', 'van Loon', 'Jonker', 'Kramer',
        'Hofman', 'Huisman', 'van der Laan', 'Schouten', 'de Haan',
        'van der Linden', 'Gerritsen', 'Cornelissen', 'Hoekstra', 'Molenaar',
        'van den Bosch', 'Veenstra', 'Koning', 'Bruinsma', 'de Groot',
        'Postma', 'Timmermans', 'Driessen', 'Boonstra', 'van der Zee',
        'Anema', 'Blom', 'van der Sluis', 'Evers', 'Hermans',
        'Keizer', 'Oosten', 'Rutgers', 'Schippers', 'ter Horst',
        'van der Veen', 'Wiersma', 'Zondervan', 'van Aken', 'Beekman',
        'van der Heijde', 'Claassen', 'Deckers', 'Eijkelboom', 'Franken',
        'Gielen', 'Hazebroek', 'IJzerman', 'Jochems', 'Kerkhof',
        'Leenders', 'Manders', 'Nijs', 'Oomens', 'Peeters',
        'Reinders', 'Smeets', 'Thijssen', 'Uijen', 'Verhoeven',
        'Wagemakers', 'Zijlstra', 'van Bergen', 'Dijkman', 'Elbers',
        'Fransen', 'Geurts', 'Heijmans', 'Janssens', 'Lambrechts',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'Netherlands';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 500), 'movie_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 500), 'movie_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 200), 'musician', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 200), 'musician', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 50), 'country_singer', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 50), 'country_singer', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 100), 'adult_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 100), 'adult_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 150), 'general', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 150), 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
