<?php

namespace Database\Seeders;

class FrenchCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Lucas', 'Léo', 'Louis', 'Gabriel', 'Raphaël',
        'Jules', 'Adam', 'Arthur', 'Hugo', 'Nathan',
        'Clément', 'Antoine', 'Alexandre', 'Nicolas', 'Thomas',
        'Pierre', 'Jean', 'François', 'Philippe', 'Laurent',
        'Michel', 'Patrick', 'Olivier', 'Christophe', 'Sébastien',
        'David', 'Julien', 'Jérôme', 'Frédéric', 'Xavier',
        'Stéphane', 'Florian', 'Mathieu', 'Damien', 'Cédric',
        'Benoît', 'Romain', 'Quentin', 'Maxime', 'Alexis',
        'Étienne', 'Vincent', 'Gilles', 'Alain', 'Bernard',
        'Daniel', 'Jacques', 'Henri', 'André', 'Marcel',
        'Gaston', 'René', 'Paul', 'Georges', 'Robert',
        'Lucien', 'Émile', 'Alphonse', 'Camille', 'Baptiste',
        'Tristan', 'Mathis', 'Ethan', 'Noah', 'Tom',
        'Enzo', 'Axel', 'Sacha', 'Rayan', 'Kylian',
        'Matteo', 'Yanis', 'Evan', 'Nolan', 'Titouan',
        'Loïc', 'Erwan', 'Gwendal', 'Yann', 'Théo',
    ];

    private array $femaleFirstNames = [
        'Emma', 'Jade', 'Louise', 'Alice', 'Chloé',
        'Lina', 'Rose', 'Léa', 'Mila', 'Manon',
        'Sarah', 'Camille', 'Marie', 'Julie', 'Sophie',
        'Isabelle', 'Catherine', 'Françoise', 'Monique', 'Christine',
        'Nathalie', 'Valérie', 'Sylvie', 'Caroline', 'Sandrine',
        'Aurélie', 'Émilie', 'Laetitia', 'Marion', 'Pauline',
        'Laura', 'Justine', 'Morgane', 'Amandine', 'Élodie',
        'Céline', 'Hélène', 'Anne', 'Jeanne', 'Marguerite',
        'Joséphine', 'Geneviève', 'Denise', 'Yvette', 'Renée',
        'Marcelle', 'Simone', 'Suzanne', 'Martine', 'Véronique',
        'Brigitte', 'Dominique', 'Michèle', 'Colette', 'Adèle',
        'Amélie', 'Éloïse', 'Clémence', 'Océane', 'Maëlys',
        'Louna', 'Romane', 'Alexia', 'Margot', 'Eva',
        'Inès', 'Léna', 'Nina', 'Lola', 'Mya',
        'Anaïs', 'Stella', 'Selma', 'Mariam', 'Aïcha',
        'Yasmina', 'Amira', 'Leila', 'Soraya', 'Nour',
    ];

    private array $lastNames = [
        'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert',
        'Richard', 'Petit', 'Durand', 'Leroy', 'Moreau',
        'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia',
        'David', 'Bertrand', 'Roux', 'Vincent', 'Fournier',
        'Morel', 'Girard', 'André', 'Lefèvre', 'Mercier',
        'Dupont', 'Lambert', 'Bonnet', 'François', 'Martinez',
        'Legrand', 'Garnier', 'Faure', 'Rousseau', 'Blanc',
        'Gérard', 'Chevalier', 'Clement', 'Rodriguez', 'Colin',
        'Perez', 'Muller', 'Gauthier', 'Fernandez', 'Lopez',
        'Fontaine', 'Picard', 'Philippe', 'Renault', 'Gonzalez',
        'Perrin', 'Barbier', 'Baron', 'Henry', 'Renaud',
        'Mathieu', 'Hubert', 'Guillaume', 'Adam', 'Pierre',
        'Menard', 'Carre', 'Arnaud', 'Dumas', 'Boyer',
        'Jean', 'Lemoine', 'Blanchard', 'Moulin', 'Rolland',
        'Dufour', 'Gillet', 'Noel', 'Boucher', 'Leroux',
        'Prevost', 'Guerin', 'Masson', 'Bonneau', 'Breton',
        'Boutin', 'Riviere', 'Lacombe', 'Bourgeois', 'Chartier',
        'Delmas', 'Boulanger', 'Charpentier', 'Fleury', 'Rey',
        'Carrier', 'Leclerc', 'Duval', 'Laporte', 'Caron',
        'Lemoine', 'Tessier', 'Besson', 'Brunet', 'Deschamps',
        'Meunier', 'Maillard', 'Gilles', 'Babin', 'Chauvin',
        'Sauvage', 'Maréchal', 'Chambon', 'Barre', 'Vallée',
        'Dupuis', 'Gaudin', 'Roussel', 'Leduc', 'Lemaire',
        'Joly', 'Poulain', 'Guérin', 'Chabot', 'Lafond',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'France';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 1000), 'movie_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 1000), 'movie_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 400), 'musician', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 400), 'musician', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 100), 'country_singer', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 100), 'country_singer', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 250), 'adult_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 250), 'adult_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 250), 'general', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 250), 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
