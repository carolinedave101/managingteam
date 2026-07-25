<?php

namespace Database\Seeders;

class GermanCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'Germany';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Til Schweiger', 'Daniel Brühl', 'Matthias Schweighöfer', 'Christoph Waltz',
            'Moritz Bleibtreu', 'Jan Josef Liefers', 'Tom Schilling', 'Alexander Fehling',
            'Franz Rogowski', 'Albrecht Schuch', 'Oliver Masucci', 'Armin Mueller-Stahl',
            'Bruno Ganz', 'Hardy Krüger', 'Heiner Lauterbach', 'Uwe Ochsenknecht',
            'Klaus Kinski', 'Maximilian Schell', 'Götz George', 'Mario Adorf',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Diane Kruger', 'Franka Potente', 'Sandra Hüller', 'Nina Hoss',
            'Martina Gedeck', 'Hanna Schygulla', 'Marlene Dietrich', 'Romy Schneider',
            'Senta Berger', 'Karoline Herfurth', 'Iris Berben', 'Veronica Ferres',
            'Barbara Sukowa', 'Hannelore Elsner', 'Nina Kunzendorf', 'Bibiana Beglau',
            'Anna Thalbach', 'Jessica Schwarz', 'Alexandra Maria Lara', 'Heike Makatsch',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'Till Lindemann', 'Richard Kruspe', 'Paul Landers', 'Oliver Riedel',
            'Herbert Grönemeyer', 'Klaus Meine', 'Rudolf Schenker', 'Peter Maffay',
            'Udo Lindenberg', 'Xavier Naidoo', 'Marius Müller-Westernhagen', 'Dieter Bohlen',
            'Mark Forster', 'Max Giesinger', 'Adel Tawil', 'Johannes Strate',
            'Sasha', 'Mickie Krause', 'Wolfgang Petry', 'Andreas Gabalier',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Helene Fischer', 'Nena', 'Sarah Connor', 'Lena Meyer-Landrut',
            'Andrea Berg', 'Yvonne Catterfeld', 'Anett Louisan', 'LaFee',
            'Jeanette Biedermann', 'Nadja Benaissa', 'Sandy Mölling', 'Lucy Diakovska',
            'Vanessa Mai', 'Michelle', 'Beatrice Egli', 'Marianne Rosenberg',
            'Cindy Berger', 'Claudia Jung', 'Kristina Bach', 'Anna-Carina Woitschack',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Heino', 'Florian Silbereisen', 'Stefan Mross', 'Andy Borg',
            'Hansi Hinterseer', 'Patrick Lindner', 'Semino Rossi', 'Nik P.',
            'Giovanni Zarrella', 'Ben Zucker',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Marianne Rosenberg', 'Claudia Jung', 'Kristina Bach', 'Anna-Carina Woitschack',
            'Nicole', 'Gitte Hænning', 'Peggy March', 'Wencke Myhre',
            'Siw Malmkvist', 'Vicky Leandros',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Horst Baron', 'Conny Dachs', 'Steve Holmes', 'David Perry',
            'Frank Major', 'Markus Waxenegger', 'Tony Rocket', 'Kevin Long',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Dolly Buster', 'Kelly Trump', 'Gina Wild', 'Conny',
            'Sharon Da Vale', 'Tina Born', 'Mandy Mystery', 'Sandy',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Michael Schumacher', 'Bastian Schweinsteiger', 'Manuel Neuer', 'Toni Kroos',
            'Thomas Müller', 'Dirk Nowitzki', 'Boris Becker', 'Sebastian Vettel',
            'Nico Rosberg', 'Miroslav Klose', 'Lothar Matthäus', 'Oliver Kahn',
            'Jürgen Klopp', 'Franz Beckenbauer', 'Gerd Müller', 'Stefan Raab',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Steffi Graf', 'Heidi Klum', 'Claudia Schiffer', 'Angela Merkel',
            'Magdalena Neuner', 'Katarina Witt', 'Anke Engelke', 'Caroline Beil',
            'Natalia Wörner', 'Marion Kracht', 'Marcia Gresch', 'Martina Navratilova',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
