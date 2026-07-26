<?php

namespace App\Console\Commands;

use App\Models\Celebrity;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;

class GenerateCelebrityDirectory extends Command
{
    protected $signature = 'generate:celebrity-directory';

    protected $description = 'Generate a PDF directory of all celebrities';

    public function handle(): int
    {
        $this->info('Fetching celebrities...');

        $celebrities = Celebrity::orderBy('category')
            ->orderBy('name')
            ->get()
            ->map(fn (Celebrity $c) => [
                'name' => $c->name,
                'category_key' => $c->category ?? 'general',
                'category_label' => $c->categoryLabel(),
                'gender' => $c->gender ? ucfirst($c->gender) : null,
                'country' => $c->country,
                'instagram' => collect($c->social_links ?? [])
                    ->firstWhere('platform', 'instagram')['url'] ?? null,
            ]);

        $count = $celebrities->count();
        $this->info("Rendering PDF for {$count} celebrities...");

        $pdf = Pdf::loadView('pdf.celebrity-directory', [
            'celebrities' => $celebrities,
        ]);

        $path = base_path('celebrity-directory.pdf');
        $pdf->save($path);

        $this->info("Done! PDF saved to: {$path}");

        return self::SUCCESS;
    }
}
