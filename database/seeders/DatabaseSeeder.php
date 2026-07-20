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
    }
}
