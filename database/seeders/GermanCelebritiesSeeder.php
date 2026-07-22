<?php

namespace Database\Seeders;

class GermanCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Lukas', 'Felix', 'Maximilian', 'Jonas', 'Leon',
        'Noah', 'Elias', 'Paul', 'Julian', 'Finn',
        'Niklas', 'Luis', 'Milan', 'Luca', 'Jakob',
        'Philipp', 'Alexander', 'Tobias', 'Christian', 'Stefan',
        'Andreas', 'Michael', 'Sebastian', 'Daniel', 'Thomas',
        'Johannes', 'Florian', 'Markus', 'Patrick', 'Christoph',
        'Benjamin', 'Nico', 'Kai', 'Jan', 'Tim',
        'Marco', 'Fabian', 'Sven', 'Dennis', 'Marcel',
        'Lars', 'Jens', 'Robert', 'Matthias', 'Oliver',
        'Martin', 'Jürgen', 'Frank', 'Peter', 'Klaus',
        'Dieter', 'Hans', 'Wolfgang', 'Manfred', 'Heinz',
        'Ralf', 'Uwe', 'Bernd', 'Horst', 'Günter',
        'Lennard', 'Marlo', 'Emil', 'Theo', 'Anton',
        'Erik', 'Oskar', 'Arthur', 'Kurt', 'Willi',
        'Ernst', 'Alfred', 'Rudolf', 'Bastian', 'Carsten',
        'Holger', 'Jörg', 'Volker', 'Axel', 'Detlef',
    ];

    private array $femaleFirstNames = [
        'Emma', 'Mia', 'Hannah', 'Sophie', 'Lea',
        'Anna', 'Lena', 'Marie', 'Emily', 'Lilli',
        'Lina', 'Amelie', 'Johanna', 'Nele', 'Clara',
        'Laura', 'Julia', 'Sarah', 'Lisa', 'Katharina',
        'Sabine', 'Susanne', 'Petra', 'Monika', 'Birgit',
        'Ursula', 'Renate', 'Heike', 'Angelika', 'Brigitte',
        'Marlene', 'Gertrud', 'Ilse', 'Ingrid', 'Ruth',
        'Mona', 'Lotte', 'Frieda', 'Alma', 'Paula',
        'Ida', 'Ella', 'Nora', 'Lara', 'Maja',
        'Luise', 'Grete', 'Elfi', 'Hannelore', 'Rosemarie',
        'Gisela', 'Erika', 'Margot', 'Edith', 'Waltraud',
        'Mathilda', 'Helene', 'Elisa', 'Greta', 'Leni',
        'Romy', 'Senta', 'Hilde', 'Dora', 'Eva',
        'Carolin', 'Annika', 'Jana', 'Nadine', 'Stefanie',
        'Vanessa', 'Nicole', 'Anne', 'Kerstin', 'Britta',
    ];

    private array $lastNames = [
        'Müller', 'Schmidt', 'Schneider', 'Fischer', 'Weber',
        'Meyer', 'Wagner', 'Becker', 'Schulz', 'Hoffmann',
        'Schäfer', 'Koch', 'Bauer', 'Richter', 'Klein',
        'Wolf', 'Schröder', 'Neumann', 'Schwarz', 'Zimmermann',
        'Braun', 'Krüger', 'Hofmann', 'Hartmann', 'Lange',
        'Schmitt', 'Werner', 'Schmitz', 'Krause', 'Meier',
        'Lehmann', 'Schmid', 'Schulze', 'Maier', 'Köhler',
        'Herrmann', 'König', 'Walter', 'Mayer', 'Huber',
        'Kaiser', 'Fuchs', 'Peters', 'Lang', 'Möller',
        'Weiß', 'Jung', 'Hahn', 'Schubert', 'Vogel',
        'Friedrich', 'Keller', 'Günther', 'Frank', 'Berger',
        'Winkler', 'Roth', 'Beck', 'Lorenz', 'Baumann',
        'Franke', 'Albrecht', 'Schuster', 'Simon', 'Ludwig',
        'Böhm', 'Winter', 'Kraus', 'Martin', 'Schumacher',
        'Jäger', 'Stein', 'Schreiber', 'Vogt', 'Sommer',
        'Engel', 'Seidel', 'Brandt', 'Horn', 'Sauer',
        'Arnold', 'Thomas', 'Bergmann', 'Busch', 'Dietrich',
        'Ziegler', 'Pohl', 'Reuter', 'Wolff', 'Beyer',
        'Groß', 'Seifert', 'Binder', 'Schilling', 'Ritter',
        'Baier', 'Henning', 'Kunz', 'Reich', 'Fiedler',
        'Haas', 'Ernst', 'Wirth', 'Adam', 'Schindler',
        'Riedel', 'Geiger', 'Heinrich', 'Unger', 'Graf',
        'Frey', 'Walter', 'Fritz', 'Brenner', 'Bartsch',
        'Moritz', 'Kern', 'Wiedemann', 'Scherer', 'Mertens',
        'Göbel', 'Lutz', 'Thiel', 'Förster', 'Reimann',
        'Bühler', 'Ackermann', 'Burkhardt', 'Steiner', 'Herzog',
        'Ebert', 'Michel', 'Konrad', 'Brückner', 'Schlegel',
        'Schuler', 'Lohmann', 'Glaser', 'Stark', 'Stahl',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'Germany';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities(
            $this->generateNames($this->maleFirstNames, $this->lastNames, 1000),
            'movie_star', 'male', $country
        );

        $this->createCelebrities(
            $this->generateNames($this->femaleFirstNames, $this->lastNames, 1000),
            'movie_star', 'female', $country
        );

        $this->createCelebrities(
            $this->generateNames($this->maleFirstNames, $this->lastNames, 400),
            'musician', 'male', $country
        );

        $this->createCelebrities(
            $this->generateNames($this->femaleFirstNames, $this->lastNames, 400),
            'musician', 'female', $country
        );

        $this->createCelebrities(
            $this->generateNames($this->maleFirstNames, $this->lastNames, 100),
            'country_singer', 'male', $country
        );

        $this->createCelebrities(
            $this->generateNames($this->femaleFirstNames, $this->lastNames, 100),
            'country_singer', 'female', $country
        );

        $this->createCelebrities(
            $this->generateNames($this->maleFirstNames, $this->lastNames, 250),
            'adult_star', 'male', $country
        );

        $this->createCelebrities(
            $this->generateNames($this->femaleFirstNames, $this->lastNames, 250),
            'adult_star', 'female', $country
        );

        $this->createCelebrities(
            $this->generateNames($this->maleFirstNames, $this->lastNames, 250),
            'general', 'male', $country
        );

        $this->createCelebrities(
            $this->generateNames($this->femaleFirstNames, $this->lastNames, 250),
            'general', 'female', $country
        );

        $this->command?->info("{$country} seeding complete.");
    }
}
