<?php

namespace Database\Seeders;

class FrenchCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'France';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Omar Sy', 'Jean Dujardin', 'Vincent Cassel', 'Gérard Depardieu',
            'Mathieu Kassovitz', 'François Cluzet', 'Guillaume Canet', 'Gaspard Ulliel',
            'Romain Duris', 'Jean Reno', 'Alain Delon', 'Yves Montand',
            'Louis de Funès', 'Jean-Paul Belmondo', 'Marcel Dalio', 'Jean Gabin',
            'Lambert Wilson', 'Clovis Cornillac', 'Benoît Poelvoorde', 'Gilles Lellouche',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Marion Cotillard', 'Catherine Deneuve', 'Léa Seydoux', 'Mélanie Laurent',
            'Adèle Exarchopoulos', 'Brigitte Bardot', 'Juliette Binoche', 'Isabelle Huppert',
            'Audrey Tautou', 'Sophie Marceau', 'Eva Green', 'Cécile de France',
            'Emmanuelle Béart', 'Fanny Ardant', 'Carole Bouquet', 'Clémence Poésy',
            'Anaïs Demoustier', 'Ludivine Sagnier', 'Noémie Merlant', 'Charlotte Gainsbourg',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'Stromae', 'Maitre Gims', 'David Guetta', 'DJ Snake',
            'Serge Gainsbourg', 'Charles Aznavour', 'Johnny Hallyday', 'Jacques Brel',
            'Édith Piaf', 'Mika', 'Zaz', 'Francis Cabrel',
            'Renaud', 'Michel Sardou', 'Joe Dassin', 'Christophe Maé',
            'Julien Doré', 'Slimane', 'Kendji Girac', 'Vianney',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Vanessa Paradis', 'Coeur de Pirate', 'Alizée', 'Indila',
            'Zazie', 'Mylène Farmer', 'Patricia Kaas', 'Françoise Hardy',
            'Dalida', 'Carla Bruni', 'Amel Bent', 'Shy\'m',
            'Jain', 'Louane', 'Christine and the Queens', 'Nolwenn Leroy',
            'Lara Fabian', 'Sylvie Vartan', 'Sheila', 'France Gall',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Tiken Jah Fakoly', 'Yannick Noah', 'Francis Lalanne', 'Alain Souchon',
            'Maxime Le Forestier', 'Georges Brassens', 'Léo Ferré', 'Henri Salvador',
            'Gilbert Bécaud', 'Renaud',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Patricia Carli', 'Marie Laforêt', 'Barbara', 'Juliette Gréco',
            'Cora Vaucaire', 'Mireille Mathieu', 'Lys Gauty', 'Fréhel',
            'Damia', 'Yvonne Printemps',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Rocco Siffredi', 'Pierre Woodman', 'David Perry', 'Brett Rock',
            'Sebastien Barrio', 'Titof', 'Matt Summers', 'Dany Desjardins',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Clara Morgane', 'Ovidie', 'Lolo Ferrari', 'Mélanie Coste',
            'Dorcel', 'Katsuni', 'Coralie Trinh Thi', 'Raffaëla Anderson',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Zinedine Zidane', 'Kylian Mbappé', 'Thierry Henry', 'Michel Platini',
            'Adrien Rabiot', 'Antoine Griezmann', 'Olivier Giroud', 'N\'Golo Kanté',
            'Paul Pogba', 'Pedro Martinez', 'Tony Parker', 'Jo-Wilfried Tsonga',
            'Teddy Riner', 'Alain Prost', 'Sébastien Loeb', 'Jean-Claude Killy',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Marie Antoinette', 'Coco Chanel', 'Édith Cresson', 'Simone Veil',
            'Christine Lagarde', 'Sophie Marceau', 'Laetitia Casta', 'Isabelle Adjani',
            'Vanessa Paradis', 'Jeanne d\'Arc', 'Brigitte Macron', 'Nathalie Péchalat',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
