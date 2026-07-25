<?php

namespace Database\Seeders;

class SpanishCelebritiesSeeder extends BaseCelebritySeeder
{
    public function run(): void
    {
        set_time_limit(0);
        $country = 'Spain';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities([
            'Javier Bardem', 'Antonio Banderas', 'Luis Tosar', 'Juan Diego Botto',
            'Fele Martínez', 'Eduardo Noriega', 'Javier Cámara', 'Miguel Ángel Silvestre',
            'Álvaro Morte', 'Mario Casas', 'Enrique Iglesias', 'Óscar Jaenada',
            'Sergio Ramos', 'David Bisbal', 'Raúl González', 'David Villa',
            'Pau Gasol', 'Rafael Nadal', 'Carlos Saura', 'Fernando Alonso',
        ], 'movie_star', 'male', $country);

        $this->createCelebrities([
            'Penélope Cruz', 'Elsa Pataky', 'Marisa Paredes', 'Rossy de Palma',
            'Carmen Maura', 'Victoria Abril', 'Cecilia Roth', 'Ana Belén',
            'Bell Roca', 'Amaia Salamanca', 'Blanca Suárez', 'María Valverde',
            'Marta Etura', 'Pilar López de Ayala', 'Nadia de Santiago', 'Adriana Ugarte',
            'Macarena Gómez', 'Inma Cuesta', 'Nathalie Poza', 'Bárbara Lennie',
        ], 'movie_star', 'female', $country);

        $this->createCelebrities([
            'Enrique Iglesias', 'David Bisbal', 'Alejandro Sanz', 'Rosario Flores',
            'Diego el Cigala', 'Joaquín Cortés', 'Pablo Alborán', 'Bisbal',
            'Juanes', 'Manuel Carrasco', 'Miguel Bosé', 'Julio Iglesias',
            'Antonio Orozco', 'Melendi', 'Dani Martín', 'Pablo López',
            'David Otero', 'Efecto Mariposa', 'El Barrio', 'Raimundo Amador',
        ], 'musician', 'male', $country);

        $this->createCelebrities([
            'Rosalía', 'Amaral', 'Lola Índigo', 'Ana Guerra',
            'Aitana', 'Nina Pastori', 'Pastora Soler', 'Luz Casal',
            'Rocío Jurado', 'Lola Flores', 'Sara Baras', 'Carmen Linares',
            'Estrella Morente', 'Montse Cortés', 'Niña Pastori', 'India Martínez',
            'Soraya Arnelas', 'Bebe', 'Rosa López', 'Merche',
        ], 'musician', 'female', $country);

        $this->createCelebrities([
            'Diego el Cigala', 'El Lebrijano', 'Camarón de la Isla', 'Paco de Lucía',
            'Enrique Morente', 'Manolo Sanlúcar', 'José Mercé', 'Miguel Poveda',
            'Duquende', 'Jesús Méndez',
        ], 'country_singer', 'male', $country);

        $this->createCelebrities([
            'Lola Flores', 'Rocío Jurado', 'Carmen Linares', 'Estrella Morente',
            'Niña Pastori', 'Mayte Martín', 'Montse Cortés', 'Ginesa Ortega',
            'María José Santiago', 'Remedios Amaya',
        ], 'country_singer', 'female', $country);

        $this->createCelebrities([
            'Torbe', 'Nacho Vidal', 'Ramon Nomar', 'Max Cortés',
            'Dany Bross', 'Marco Lene', 'Dirk McQuick', 'Toni Ribas',
            'Jordi', 'Nilo',
        ], 'adult_star', 'male', $country);

        $this->createCelebrities([
            'Amarna Miller', 'Maria Lapiedra', 'Sofía del Valle', 'Lena Nitro',
            'Gina LaMar', 'Celia Blanco', 'Sandra Cana', 'Salycita',
        ], 'adult_star', 'female', $country);

        $this->createCelebrities([
            'Rafael Nadal', 'Pau Gasol', 'Sergio Ramos', 'Andrés Iniesta',
            'Xavi Hernández', 'Iker Casillas', 'Carles Puyol', 'Fernando Alonso',
            'Carlos Sainz', 'Marc Márquez', 'Ángel Nieto', 'Seve Ballesteros',
            'Carlos Alcaraz', 'Juan Carlos Navarro', 'David Ferrer', 'Garbiñe Muguruza',
        ], 'general', 'male', $country);

        $this->createCelebrities([
            'Isabel II', 'Garbiñe Muguruza', 'Cristina Sánchez', 'Carolina Marín',
            'Lydia Valentín', 'Mireia Belmonte', 'Tamara Rojo', 'Ana Botín',
            'María Teresa Fernández de la Vega', 'Carmen Calvo', 'Soraya Sáenz de Santamaría',
            'Lola Herrera',
        ], 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
