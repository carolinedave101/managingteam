<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbWarmup extends Command
{
    protected $signature = 'db:warmup';

    protected $description = 'Warm up the database connection (Neon cold start mitigation)';

    public function handle(): void
    {
        $this->components->task('Warming up database connection', function () {
            DB::select('SELECT 1');
            DB::select('SELECT COUNT(*) FROM celebrities');
            DB::select('SELECT COUNT(*) FROM users');
        });
    }
}
