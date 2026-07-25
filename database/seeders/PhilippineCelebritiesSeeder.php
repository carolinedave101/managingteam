<?php

namespace Database\Seeders;

class PhilippineCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'Philippines';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Coco Martin', 'Daniel Padilla', 'Alden Richards', 'Piolo Pascual',
            'John Lloyd Cruz', 'Derek Ramsay', 'Jericho Rosales', 'Enrique Gil',
            'Rico Blanco', 'James Reid', 'Rayver Cruz', 'Xian Lim',
            'Ruru Madrid', 'Tom Rodriguez', 'Bg Gonzales', 'Ronnie Alonte',
            'Gabby Concepcion', 'Aga Muhlach', 'Richard Gomez', 'Robin Padilla',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Kathryn Bernardo', 'Liza Soberano', 'Marian Rivera', 'Angel Locsin',
            'Bea Alonzo', 'Sarah Geronimo', 'Kim Chiu', 'Nora Aunor',
            'Sharon Cuneta', 'Maja Salvador', 'Julia Montes', 'Ruffa Gutierrez',
            'Heart Evangelista', 'Jodi Sta Maria', 'Kris Aquino', 'Vilma Santos',
            'Megan Young', 'Gloria Diaz', 'Vice Ganda', 'Pokwang',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'Jose Mari Chan', 'Regine Velasquez', 'Ogie Alcasid', 'Christian Bautista',
            'Erik Santos', 'Gary Valenciano', 'Martin Nievera', 'Richard Poon',
            'Jonalyn Viray', 'Jed Madela', 'Rico Blanco', 'Gloc-9',
            'Abra', 'Sahid', 'Yeng Constantino', 'Bamboo Manalac',
            'Jay Durias', 'Ryan Cayabyab', 'Jim Bondad', 'Jake Zyrus',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Sarah Geronimo', 'Regine Velasquez', 'Lea Salonga', 'Zsa Zsa Padilla',
            'Kuh Ledesma', 'Kyla', 'Jaya', 'Nina Girado',
            'Yeng Constantino', 'Angeline Quinto', 'Morissette', 'Kylie Verzosa',
            'Bituin Escalante', 'Angelina Cruz', 'Toni Gonzaga', 'Vice Ganda',
            'Pati Cantu', 'ASAP', 'Lilet', 'Megan Young',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Freddie Aguilar', 'Ruben Tagalog', 'Jose Valdez', 'Victor Wood',
            'Diomedes Maturan', 'Donna Cruz', 'Rey Valera', 'Rudy Lozano',
            'Eddie Peregrina', 'Esther Sanares',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Pilita Corrales', 'Nora Aunor', 'Sylvia La Torre', 'Helen Tiongson',
            'Rebecca del Rio', 'Carmencita Lopéz', 'Yolanda Guevarra', 'Josephine Rocha',
            'Lydia G. Orosa', 'Carmina Razon',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Allen Dee', 'Miko Cruz', 'Rodel Dalisay', 'Marco Villanueva',
            'Bong Rojales', 'RJ Segismundo', 'Jimmy Mendez', 'Jao Alvarado',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Katrina Cruz', 'Megan Young', 'Bella Padilla', 'Sofia Alcantara',
            'Chantelle Martinez', 'Diana Zubiri', 'Maui Taylor', 'Kylie Mendoza',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Manny Pacquiao', 'Paeng Nepomuceno', 'Eugene Torre', 'Carlos Yulo',
            'Hidilyn Diaz', 'Nesthy Petecio', 'Maine Mendoza', 'Enrique Gil',
            'Jose Rizal', 'Ferdinand Marcos', 'Rodrigo Duterte', 'Bongbong Marcos',
            'Benigno Aquino III', 'Isabel Preysler', 'Lou Diamond Phillips', 'Bruno Mars',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Megan Young', 'Pia Wurtzbach', 'Catriona Gray', 'Gloria Diaz',
            'Margie Moran', 'Kris Aquino', 'Mel Tiangco', 'Karen Davila',
            'Vilma Santos', 'Nora Aunor', 'Katherine Luna', 'Angel Aquino',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
