<?php

namespace Database\Seeders;

class DutchCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'Netherlands';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Rutger Hauer', 'Michiel Huisman', 'Jeroen Krabbé', 'Huub Stapel',
            'Derek de Lint', 'Gijsbert Roelofs', 'Marwan Kenzari', 'Barry Atsma',
            'Cas Jansen', 'Mark van Eeuwen', 'Loek Kemps', 'Guy Clemens',
            'Thijs Römer', 'Bobbi Eden', 'Jim Bakkum', 'Edwin Jonker',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Carice van Houten', 'Famke Janssen', 'Katja Schuurman', 'Maruschka Detmers',
            'Monique van de Ven', 'Renée Soutendijk', 'Johanna ter Steege', 'Thekla Reuten',
            'Halina Reijn', 'Anna Drijver', 'Sylvia Kristel', 'Liesbeth Stassen',
            'Willeke van Ammelrooy', 'Nelly Frijda', 'Olga Zuiderhoek', 'Anneke Grönloh',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'Eddie van Halen', 'Alex van Halen', 'Armin van Buuren', 'Martin Garrix',
            'DJ Tiësto', 'Afrojack', 'Hardwell', 'Don Diablo',
            'Oliver Heldens', 'Nicky Romero', 'Blasterjaxx', 'Marco V',
            'W&W', 'Ran-D', 'Angerfist', 'Dennis van der Geest',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Anouk', 'Carrie van Houten', 'Glennis Grace', 'Ruth Jacott',
            'Ilse DeLange', 'Eva Simons', 'Kim-Lian van der Meij', 'Sanna van der Vliet',
            'Leona Philippo', 'Britt Dekker', 'Maan', 'Trijntje Oosterhuis',
            'Edsilia Rombley', 'Margriet Eshuys', 'Sandy Kandau', 'Liza de Moret',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Marco Borsato', 'André Hazes', 'Frans Bauer', 'Jan Smit',
            'René Froger', 'Danny Vera', 'Jos Brink', 'Gert Timmerman',
            'Boer Koekoek', 'Willem Alexander',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Annie Schilder', 'Tineke Schouten', 'Hanny Vogts', 'Liesbeth List',
            'Jannette van Wijk', 'Anouk', 'Maya', 'Ellen ten Damme',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Milan van der Burg', 'Dennis Bier', 'Mark van der Wal', 'Bob van der Hulst',
            'Chris van de Velde', 'Lennart van Zanten', 'Jeroen van Dijk', 'Peter van der Heyden',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Bobbi Eden', 'Bianca Trump', 'Kim Holland', 'Samantha Fox',
            'Stella Cox', 'Shalina Devine', 'Tiffany Rousso', 'Dominique van de Pol',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Johan Cruyff', 'Ruud Gullit', 'Marco van Basten', 'Arjen Robben',
            'Virgil van Dijk', 'Dennis Bergkamp', 'Wesley Sneijder', 'Robin van Persie',
            'Edwin van der Sar', 'Ruud van Nistelrooy', 'Max Verstappen', 'Tom Dumoulin',
            'Sven Kramer', 'Ireen Wüst', 'Pieter van den Hoogenband', 'Inge de Bruijn',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Marianne Vos', 'Leontien van Moorsel', 'Lieke Martens', 'Dafne Schippers',
            'Ellen van Dijk', 'Joanna Leighton', 'Vivianne Miedema', 'Sofia Johansson',
            'Mona Keijzer', 'Marlies Veldhuijzen', 'Sylvia van der Heiden', 'Ellie Lust',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
