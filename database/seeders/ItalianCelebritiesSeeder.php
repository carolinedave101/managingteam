<?php

namespace Database\Seeders;

class ItalianCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Marco', 'Lorenzo', 'Alessandro', 'Francesco', 'Andrea',
        'Matteo', 'Luca', 'Giovanni', 'Riccardo', 'Edoardo',
        'Gabriele', 'Federico', 'Tommaso', 'Leonardo', 'Nicolò',
        'Diego', 'Filippo', 'Daniele', 'Pietro', 'Antonio',
        'Giuseppe', 'Mario', 'Luigi', 'Roberto', 'Stefano',
        'Paolo', 'Claudio', 'Massimo', 'Fabio', 'Giulio',
        'Gianluca', 'Simone', 'Alberto', 'Davide', 'Sergio',
        'Vittorio', 'Salvatore', 'Enrico', 'Giorgio', 'Carlo',
        'Franco', 'Michele', 'Angelo', 'Raffaele', 'Alfredo',
        'Gennaro', 'Ciro', 'Pasquale', 'Achille', 'Alfonso',
        'Dario', 'Ettore', 'Fausto', 'Giacomo', 'Guido',
        'Leandro', 'Luciano', 'Moreno', 'Osvaldo', 'Ruggero',
        'Silvio', 'Tiziano', 'Valerio', 'Walter', 'Zeno',
        'Amedeo', 'Bruno', 'Corrado', 'Egidio', 'Flavio',
        'Graziano', 'Ivano', 'Lamberto', 'Nando', 'Orlando',
        'Paride', 'Quirino', 'Remo', 'Sabino', 'Tullio',
    ];

    private array $femaleFirstNames = [
        'Sofia', 'Giulia', 'Aurora', 'Alice', 'Ginevra',
        'Emma', 'Giorgia', 'Beatrice', 'Anna', 'Martina',
        'Sara', 'Chiara', 'Noemi', 'Francesca', 'Elena',
        'Valentina', 'Federica', 'Silvia', 'Laura', 'Elisa',
        'Alessia', 'Giovanna', 'Maria', 'Rosa', 'Teresa',
        'Angela', 'Caterina', 'Daniela', 'Erika', 'Barbara',
        'Cinzia', 'Debora', 'Eleonora', 'Flavia', 'Gabriella',
        'Ilaria', 'Katia', 'Letizia', 'Maddalena', 'Nadia',
        'Olga', 'Paola', 'Rachele', 'Sabrina', 'Tiziana',
        'Valeria', 'Veronica', 'Wilma', 'Ylenia', 'Zaira',
        'Adriana', 'Bianca', 'Carmela', 'Donatella', 'Enrica',
        'Fabiana', 'Giulia', 'Helena', 'Iolanda', 'Jessica',
        'Lara', 'Manuela', 'Natalina', 'Olimpia', 'Patrizia',
        'Raffaella', 'Santina', 'Tatiana', 'Ursula', 'Vanessa',
        'Angelica', 'Benedetta', 'Celeste', 'Diana', 'Elda',
        'Fiorella', 'Grazia', 'Isabella', 'Loredana', 'Miriam',
    ];

    private array $lastNames = [
        'Rossi', 'Russo', 'Ferrari', 'Esposito', 'Bianchi',
        'Romano', 'Colombo', 'Ricci', 'Marino', 'Greco',
        'Bruno', 'Gallo', 'Conti', 'Costa', 'Mancini',
        'Barbieri', 'Fontana', 'Rinaldi', 'Caruso', 'Moretti',
        'Martini', 'Leone', 'Marchetti', 'Morelli', 'Giordano',
        'Rizzi', 'Lombardi', 'Grassi', 'Palmieri', 'Fabbri',
        'Serra', 'Cattaneo', 'Pellegrini', 'Gatti', 'Ferrara',
        'Vitali', 'Battaglia', 'Sartori', 'Barone', 'Guerra',
        'Costantini', 'Monti', 'Parisi', 'Pisani', 'Ruggiero',
        'Carbone', 'Ferretti', 'Martinelli', 'Mazza', 'Amato',
        'Bellini', 'Graziani', 'Longhi', 'Bernardi', 'Caputo',
        'Cavallo', 'Coppola', 'De Luca', 'Fiore', 'Gentile',
        'Guerriero', 'Marinelli', 'Messina', 'Milani', 'Montanari',
        'Negri', 'Orlandi', 'Pagani', 'Piras', 'Poli',
        'Riva', 'Rossetti', 'Salvadori', 'Sanna', 'Santoro',
        'Sartori', 'Silvestri', 'Sorrentino', 'Trentini', 'Valentini',
        'Villa', 'Visconti', 'Zanetti', 'Zanella', 'Zanardi',
        'Brambilla', 'Calabrese', 'Cattani', 'Corradi', 'Ferrarini',
        'Giannini', 'Lorenzini', 'Mattioli', 'Nanni', 'Pasquini',
        'Piccoli', 'Rampini', 'Sorrentino', 'Tassinari', 'Ugolini',
        'Venturini', 'Zamboni', 'Zaniboni', 'Zaccagnini', 'Toscani',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'Italy';

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
