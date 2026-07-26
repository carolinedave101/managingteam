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
        ini_set('memory_limit', '512M');
        set_time_limit(600);
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

        $this->info('Loading PDF view...');

        $this->info('Loading PDF view...');

        try {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->set_option('isRemoteEnabled', false);
            $dompdf->set_option('isHtml5ParserEnabled', true);
            $dompdf->set_option('defaultFont', 'DejaVu Sans');

            $html = view('pdf.celebrity-directory', [
                'celebrities' => $celebrities,
            ])->render();

            $dompdf->loadHtml($html);
            $dompdf->setPaper('a4', 'landscape');
            $dompdf->render();

            $path = base_path('celebrity-directory.pdf');
            file_put_contents($path, $dompdf->output());
        } catch (\Exception $e) {
            $this->error('PDF generation failed: '.$e->getMessage());
            return self::FAILURE;
        }

        $this->info("Done! PDF saved to: {$path}");

        return self::SUCCESS;
    }
}
