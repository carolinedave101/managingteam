<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            fn (): string => <<<'HTML'
<style>
.fi-main { max-width: 100% !important; width: 100% !important; }
.fi-page-content { max-width: 100% !important; width: 100% !important; }
.fi-grid-col { --col-span-default: 1 / -1 !important; width: 100% !important; }
.fi-fo-field { grid-template-columns: 1fr !important; }
.fi-fo-field-label-col { width: 100% !important; }
.fi-fo-field-content-col { width: 100% !important; }
.fi-fo-field.fi-fo-field-has-inline-label { grid-template-columns: 1fr !important; }
.fi-fo-field.fi-fo-field-has-inline-label .fi-fo-field-content-col { grid-column: 1 !important; }
</style>
HTML,
        );
    }
}
