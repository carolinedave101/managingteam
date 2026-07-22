<?php

namespace Database\Seeders;

class PhilippineCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Juan', 'Jose', 'Manuel', 'Carlos', 'Antonio',
        'Pedro', 'Miguel', 'Ramon', 'Francisco', 'Andres',
        'Jose', 'Rafael', 'Eduardo', 'Fernando', 'Ricardo',
        'Alberto', 'Emilio', 'Enrique', 'Gabriel', 'Hector',
        'Ismael', 'Jaime', 'Joaquin', 'Leonardo', 'Luis',
        'Marcos', 'Nicolas', 'Orlando', 'Pablo', 'Raul',
        'Rodrigo', 'Salvador', 'Sergio', 'Tomas', 'Vicente',
        'Alejandro', 'Benito', 'Cesar', 'Diego', 'Esteban',
        'Felipe', 'Gonzalo', 'Ignacio', 'Julian', 'Lorenzo',
        'Mateo', 'Nelson', 'Oscar', 'Pascual', 'Rolando',
        'Adrian', 'Bienvenido', 'Cristobal', 'Dante', 'Elmer',
        'Fidel', 'Gaudencio', 'Herminio', 'Isidro', 'Jerome',
        'Kevin', 'Leo', 'Mario', 'Noel', 'Omar',
        'Paulo', 'Quirino', 'Roderick', 'Simeon', 'Teodoro',
        'Urbano', 'Victor', 'Wilfredo', 'Xavier', 'Zosimo',
        'Arnel', 'Bong', 'Crispin', 'Danilo', 'Edgardo',
        'Froilan', 'Gregorio', 'Hilario', 'Joven', 'Kendrick',
        'Lito', 'Monico', 'Nilo', 'Ponciano', 'Romeo',
    ];

    private array $femaleFirstNames = [
        'Maria', 'Josefina', 'Teresa', 'Carmen', 'Elena',
        'Gloria', 'Luzviminda', 'Corazon', 'Leticia', 'Mercedes',
        'Fe', 'Rosario', 'Concepcion', 'Remedios', 'Milagros',
        'Consuelo', 'Esperanza', 'Aurora', 'Dolores', 'Natividad',
        'Soledad', 'Lourdes', 'Guadalupe', 'Pilar', 'Visitacion',
        'Imelda', 'Ligaya', 'Luz', 'Cristina', 'Adelaida',
        'Belen', 'Caridad', 'Divina', 'Erminda', 'Flor',
        'Graciana', 'Honorata', 'Iluminada', 'Jovita', 'Lilia',
        'Marilyn', 'Nenita', 'Ofelia', 'Perlita', 'Rosalinda',
        'Salud', 'Trinidad', 'Virginia', 'Wilma', 'Zenaida',
        'Angelina', 'Bianca', 'Celia', 'Diana', 'Elisa',
        'Fatima', 'Gemma', 'Hilda', 'Isabel', 'Julia',
        'Katrina', 'Lara', 'Martha', 'Nora', 'Oliva',
        'Patricia', 'Queen', 'Rowena', 'Sandra', 'Tina',
        'Ursula', 'Valerie', 'Wendy', 'Yvonne', 'Zarah',
        'Aimee', 'Bernadette', 'Clarissa', 'Danica', 'Erica',
        'Francine', 'Giselle', 'Hazel', 'Iris', 'Janine',
    ];

    private array $lastNames = [
        'Santos', 'Cruz', 'Reyes', 'Gonzales', 'Bautista',
        'Mendoza', 'Garcia', 'Torres', 'Rivera', 'Fernandez',
        'Villanueva', 'Ramos', 'Aquino', 'Castillo', 'Francisco',
        'Dela Cruz', 'Lopez', 'Gomez', 'Domingo', 'Magsaysay',
        'Cortez', 'Aguilar', 'Navarro', 'Palma', 'Romero',
        'Santiago', 'Alcantara', 'Burgos', 'Castro', 'De Leon',
        'Enriquez', 'Flores', 'Guevarra', 'Hernandez', 'Ilustre',
        'Jacinto', 'Lazaro', 'Martinez', 'Nacionales', 'Ortega',
        'Pascual', 'Quizon', 'Ramirez', 'Salvador', 'Tolentino',
        'Uy', 'Vargas', 'Yambao', 'Zamora', 'Abad',
        'Alonzo', 'Belen', 'Cabrera', 'David', 'Espiritu',
        'Fabia', 'Galang', 'Hermosa', 'Ibañez', 'Jimenez',
        'Lozano', 'Marquez', 'Nunez', 'Ocampo', 'Peña',
        'Quinto', 'Roldan', 'Sabino', 'Tavera', 'Valencia',
        'Wagan', 'Yabut', 'Zaragoza', 'Abella', 'Alcantara',
        'Baquiran', 'Cabangon', 'Dimagiba', 'Estrada', 'Fernandez',
        'Gatdula', 'Hizon', 'Isidro', 'Javierto', 'Kapunan',
        'Lansang', 'Manaloto', 'Nagtalon', 'Ondoy', 'Panganiban',
        'Quiambao', 'Rongavilla', 'Sangalang', 'Tiangco', 'Umali',
        'Vibar', 'Yango', 'Zulueta', 'Almario', 'Baluyot',
        'Canlas', 'Dizon', 'Evangelista', 'Gutierrez', 'Herrera',
        'Infante', 'Jocson', 'Katigbak', 'Lacson', 'Manansala',
        'Narvasa', 'Oreta', 'Pardo', 'Quimbo', 'Romualdez',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'Philippines';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 500), 'movie_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 500), 'movie_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 200), 'musician', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 200), 'musician', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 50), 'country_singer', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 50), 'country_singer', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 100), 'adult_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 100), 'adult_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 150), 'general', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 150), 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
