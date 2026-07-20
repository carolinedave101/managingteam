<?php

namespace App\Filament\Admin\Pages;

use App\Models\Celebrity;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class DemoFanCredentials extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.admin.pages.demo-fan-credentials';

    protected static ?string $slug = 'demo-credentials';

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public static function getNavigationLabel(): string
    {
        return 'Demo Credentials';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Celebrity::query()->orderBy('name'))
            ->paginated(false)
            ->striped()
            ->columns([
                TextColumn::make('name')
                    ->label('Celebrity')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Portal')
                    ->formatStateUsing(fn (string $state): string => $state.'.managingteam.info')
                    ->copyable()
                    ->copyMessage('Portal URL copied')
                    ->color('gray'),
                TextColumn::make('demo_email')
                    ->label('Email')
                    ->getStateUsing(fn (Celebrity $record): string => $record->slug.'1@demo.com')
                    ->copyable()
                    ->copyMessage('Email copied')
                    ->copyMessageDuration(1500),
                TextColumn::make('demo_password')
                    ->label('Password')
                    ->default('demo1234!')
                    ->copyable()
                    ->copyMessage('Password copied')
                    ->copyMessageDuration(1500)
                    ->color('danger'),
            ])
            ->defaultSort('name');
    }
}
