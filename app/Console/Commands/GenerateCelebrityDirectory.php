<?php

namespace App\Console\Commands;

use App\Models\Celebrity;
use Illuminate\Console\Command;
use Mpdf\Mpdf;

class GenerateCelebrityDirectory extends Command
{
    protected $signature = 'generate:celebrity-directory';

    protected $description = 'Generate a PDF directory of all celebrities';

    public function handle(): int
    {
        ini_set('memory_limit', '512M');
        ini_set('pcre.backtrack_limit', '4000000');
        set_time_limit(300);
        $this->info('Fetching celebrities...');

        $celebrities = Celebrity::orderBy('category')
            ->orderBy('name')
            ->get()
            ->map(fn (Celebrity $c) => [
                'name' => $c->name,
                'category_label' => $c->categoryLabel(),
                'gender' => $c->gender ? ucfirst($c->gender) : null,
                'country' => $c->country,
                'instagram' => collect($c->social_links ?? [])
                    ->firstWhere('platform', 'instagram')['url'] ?? null,
            ]);

        $count = $celebrities->count();
        $this->info("Rendering PDF for {$count} celebrities...");

        $html = view('pdf.celebrity-directory', [
            'celebrities' => $celebrities,
        ])->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'tempDir' => storage_path('app/mpdf-tmp'),
        ]);

        $mpdf->WriteHTML($html);

        $path = base_path('celebrity-directory.pdf');
        $mpdf->Output($path, 'F');

        $this->info("Done! PDF saved to: {$path}");

        return self::SUCCESS;
    }
}
