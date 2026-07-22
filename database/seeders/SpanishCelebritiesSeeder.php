<?php

namespace Database\Seeders;

class SpanishCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Antonio', 'Manuel', 'José', 'Francisco', 'David',
        'Juan', 'Javier', 'Daniel', 'Carlos', 'Miguel',
        'Alejandro', 'Rafael', 'Pedro', 'Ángel', 'Luis',
        'Sergio', 'Pablo', 'Jorge', 'Alberto', 'Fernando',
        'Diego', 'Adrián', 'Álvaro', 'Víctor', 'Iván',
        'Enrique', 'Ramón', 'Andrés', 'Rubén', 'Óscar',
        'Alfonso', 'Gonzalo', 'Julio', 'Jaime', 'Vicente',
        'Marcos', 'Joaquín', 'Ignacio', 'Eduardo', 'Santiago',
        'Jesús', 'Mariano', 'Felipe', 'Nicolás', 'Tomás',
        'Mario', 'Hugo', 'Martín', 'Pau', 'Marc',
        'Albert', 'Jordi', 'Carles', 'Oriol', 'Guillem',
        'Unai', 'Ander', 'Aitor', 'Iker', 'Jon',
        'Xavier', 'Pol', 'Nil', 'Jan', 'Biel',
        'Cristian', 'Kevin', 'Joel', 'Alex', 'Dani',
        'Raúl', 'Ismael', 'Héctor', 'Samuel', 'Lucas',
    ];

    private array $femaleFirstNames = [
        'María', 'Carmen', 'Ana', 'Laura', 'Isabel',
        'Dolores', 'Cristina', 'Marta', 'Elena', 'Sara',
        'Lucía', 'Paula', 'Sofía', 'Claudia', 'Irene',
        'Nerea', 'Alba', 'Rosa', 'Teresa', 'Mercedes',
        'Victoria', 'Rocío', 'Pilar', 'Concepción', 'Josefa',
        'Encarnación', 'Ángeles', 'Antonia', 'Francisca', 'Amparo',
        'Lourdes', 'Montserrat', 'Nuria', 'Mireia', 'Laia',
        'Carla', 'Marina', 'Ariadna', 'Emma', 'Julia',
        'Valeria', 'Noa', 'Aina', 'Ona', 'Abril',
        'Carlota', 'Mariona', 'Berta', 'Candela', 'Jimena',
        'Lola', 'Manuela', 'Adriana', 'Andrea', 'Silvia',
        'Beatriz', 'Raquel', 'Eva', 'Patricia', 'Verónica',
        'Alicia', 'Natalia', 'Vanessa', 'Esther', 'Inés',
        'Paloma', 'Yolanda', 'Aurora', 'Blanca', 'Gloria',
        'Esperanza', 'Soledad', 'Milagros', 'Rosario', 'Lidia',
    ];

    private array $lastNames = [
        'García', 'Rodríguez', 'Martínez', 'López', 'Sánchez',
        'Pérez', 'González', 'Fernández', 'Gómez', 'Martín',
        'Jiménez', 'Ruiz', 'Hernández', 'Díaz', 'Moreno',
        'Muñoz', 'Álvarez', 'Romero', 'Alonso', 'Navarro',
        'Torres', 'Domínguez', 'Vázquez', 'Ramos', 'Gil',
        'Ramírez', 'Serrano', 'Blanco', 'Molina', 'Morales',
        'Ortega', 'Delgado', 'Castro', 'Ortiz', 'Rubio',
        'Marín', 'Sanz', 'Medina', 'Castillo', 'Cortés',
        'Garrido', 'Santos', 'Lozano', 'Guerrero', 'Núñez',
        'Cano', 'Prieto', 'Méndez', 'Cruz', 'Gallego',
        'Calvo', 'Vidal', 'León', 'Peña', 'Márquez',
        'Cabrera', 'Flores', 'Campos', 'Vega', 'Carrasco',
        'Fuentes', 'Diez', 'Iglesias', 'Caballero', 'Aguilar',
        'Pascual', 'Pastor', 'Reyes', 'Expósito', 'Herrero',
        'Ferrer', 'Soler', 'Benítez', 'Santiago', 'Roca',
        'Pujol', 'Mas', 'Vila', 'Rovira', 'Costa',
        'Font', 'Pons', 'Puig', 'Ferrer', 'Esteve',
        'Casas', 'Riera', 'Comas', 'Camps', 'Sala',
        'Bosch', 'Amorós', 'Palau', 'Grau', 'Coll',
        'Soler', 'Cervera', 'Olivé', 'Moya', 'Balaguer',
        'Tejedor', 'Mengual', 'Barrera', 'Hidalgo', 'Vivancos',
        'Ballester', 'Alcaraz', 'Roselló', 'Lladó', 'Torrents',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'Spain';

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
