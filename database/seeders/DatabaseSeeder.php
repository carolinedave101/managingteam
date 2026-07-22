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
        $this->call(FemaleEuropeanActressesSeeder::class);
        $this->call(FemaleEuropeanMusiciansSeeder::class);
        $this->call(FemaleAdultStarsSeeder::class);
        $this->call(MaleAdultStarsSeeder::class);

        $this->call(GermanCelebritiesSeeder::class);
        $this->call(FrenchCelebritiesSeeder::class);
        $this->call(SpanishCelebritiesSeeder::class);
        $this->call(ItalianCelebritiesSeeder::class);
        $this->call(DutchCelebritiesSeeder::class);
        $this->call(JapaneseCelebritiesSeeder::class);
        $this->call(ChineseCelebritiesSeeder::class);
        $this->call(SouthKoreanCelebritiesSeeder::class);
        $this->call(PhilippineCelebritiesSeeder::class);
        $this->call(ThaiCelebritiesSeeder::class);
    }
}
