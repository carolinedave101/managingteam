<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(DefaultDataSeeder::class);
        $this->call(MovieStarSeeder::class);
        $this->call(MoreMovieStarSeeder::class);
        $this->call(CountryMaleSingersSeeder::class);
        $this->call(FemaleMovieActressesSeeder::class);
        $this->call(FemaleCountrySingersSeeder::class);
        $this->call(MaleEuropeanActorsSeeder::class);
        $this->call(MaleEuropeanSingersSeeder::class);
    }
}
