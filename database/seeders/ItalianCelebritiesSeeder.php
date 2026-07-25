<?php

namespace Database\Seeders;

class ItalianCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'Italy';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Roberto Benigni', 'Marcello Mastroianni', 'Vittorio Gassman', 'Alberto Sordi',
            'Nino Manfredi', 'Adriano Celentano', 'Giancarlo Giannini', 'Michele Placido',
            'Sergio Castellitto', 'Kim Rossi Stuart', 'Toni Servillo', 'Pierfrancesco Favino',
            'Elio Germano', 'Alessandro Borghi', 'Marco Giallini', 'Valerio Mastandrea',
            'Claudio Gioè', 'Francesco Montanari', 'Luca Marinelli', 'Riccardo Scamarcio',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Sophia Loren', 'Monica Bellucci', 'Gina Lollobrigida', 'Anna Magnani',
            'Claudia Cardinale', 'Mariangela Melato', 'Laura Morante', 'Sabrina Ferilli',
            'Alba Rohrwacher', 'Paola Cortellesi', 'Micaela Ramazzotti', 'Valeria Golino',
            'Elena Sofia Ricci', 'Stefania Sandrelli', 'Ornella Muti', 'Virna Lisi',
            'Sonia Braga', 'Margherita Buy', 'Giovanna Mezzogiorno', 'Jasmine Trinca',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'Andrea Bocelli', 'Luciano Pavarotti', 'Eros Ramazzotti', 'Zucchero',
            'Adriano Celentano', 'Enrico Caruso', 'Tiziano Ferro', 'Fabrizio De André',
            'Lucio Battisti', 'Gino Paoli', 'Lucio Dalla', 'Franco Battiato',
            'Jovanotti', 'Giorgia Moroder', 'Vasco Rossi', 'Francesco De Gregori',
            'Antonio Venditti', 'Pino Daniele', 'Giuseppe Verdi', 'Giacomo Puccini',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Laura Pausini', 'Elisa', 'Mina', 'Gianna Nannini',
            'Ornella Vanoni', 'Rita Pavone', 'Fiorella Mannoia', 'Ivana Spagna',
            'Noemi', 'Emma Marrone', 'Alessandra Amoroso', 'Annalisa',
            'Arisa', 'Malika Ayane', 'Greta', 'Francesca Michielin',
            'Nek', 'Giorgia', 'Irene Grandi', 'Alice',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Lucio Battisti', 'Vasco Rossi', 'Fabrizio De André', 'Francesco Guccini',
            'Antonio Venditti', 'Rino Gaetano', 'Sergio Endrigo', 'Giorgio Gaber',
            'Roberto Vecchioni', 'Angelo Branduardi',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Alice', 'Erica Mou', 'Carmen Consoli', 'Giusy Ferreri',
            'Mietta', 'Marina Rei', 'Cristina D\'Avena', 'Donatella Rettore',
            'Amanda Lear', 'Sabrina Starke',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Rocco Siffredi', 'Gabriel Pio', 'Denis Marti', 'Frank Bolland',
            'Ruggero Boscaglia', 'Franco Trentalance', 'Luca Damiano', 'Marco Trevi',
            'Dario Grillo', 'Andrea Nobili',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Eva Henger', 'Jessica Rizzo', 'Milena Dravic', 'Megan Max',
            'Debbie White', 'Raffaella Ponzo', 'Cristina Rinaldi', 'Katrina Mayer',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Giorgio Armani', 'Valentino Rossi', 'Gianluigi Buffon', 'Mario Balotelli',
            'Roberto Baggio', 'Paolo Maldini', 'Leonardo da Vinci', 'Michelangelo',
            'Enrico Fermi', 'Galileo Galilei', 'Silvio Berlusconi', 'Romano Prodi',
            'Alberto Tomba', 'Gigi Riva', 'Marco Tardelli', 'Fabio Cannavaro',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Isabella Rossellini', 'Milena Vukotic', 'Donatella Versace', 'Miuccia Prada',
            'Elisabetta Canalis', 'Madalina Ghenea', 'Carla Fracci', 'Valentina Vezzali',
            'Federica Pellegrini', 'Maria Curcio', 'Sofia Loren', 'Gina Lollobrigida',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
