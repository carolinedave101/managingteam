<?php

namespace App\Filament\Admin\Resources\RedirectLinks\Schemas;

use App\Models\Celebrity;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class RedirectLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Link Details')
                    ->description('Configure short, trackable redirect links (e.g. /r/kd8s2f) that route fans to a celebrity portal or any external URL. Each link is tied to a celebrity and auto-fills the target URL from their portal address. Use the code field to create custom short codes, then share the generated short URL on social media, flyers, or emails. Inactive links return a 404, so you can disable them without deleting.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $celebrity = Celebrity::find($state);
                                    if ($celebrity) {
                                        $set('target_url', $celebrity->getPortalUrl());
                                    }
                                }
                            })
                            ->helperText('Choose the celebrity whose portal this link should point to. When selected, the Target URL below is auto-populated with the celebrity\'s portal URL (e.g. https://celebrity.managingteam.info). This ensures the link sends fans to the correct portal. Required — every redirect link must be tied to a celebrity.'),
                        TextInput::make('code')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->default(fn () => Str::random(6))
                            ->suffixAction(
                                Action::make('regenerate')
                                    ->icon('heroicon-o-arrow-path')
                                    ->action(function ($state, callable $set) {
                                        $set('code', Str::random(6));
                                    })
                            )
                            ->helperText('The alphanumeric code that forms the short URL path: /r/{code}. Must be unique across all redirect links. Max 50 characters. Auto-generates a random 6-character string by default; click the refresh icon (↻) to generate a new random code. You can also type a custom code (e.g. "summer-tour") for memorable links. Live preview of the full short URL appears below after typing.'),
                        Placeholder::make('short_url')
                            ->label('Short URL')
                            ->content(fn ($get) => new HtmlString(
                                $get('code')
                                    ? '<div class="flex items-center gap-3">'
                                        .'<a href="'.e(url('/r/'.$get('code'))).'" target="_blank" rel="noopener noreferrer" class="font-mono text-sm text-primary-600 hover:text-primary-800 underline">'
                                        .e(url('/r/'.$get('code')))
                                        .'</a>'
                                        .'<button type="button" onclick="navigator.clipboard.writeText(\''.e(url('/r/'.$get('code'))).'\').then(() => { this.classList.add(\'text-green-600\'); setTimeout(() => this.classList.remove(\'text-green-600\'), 1500); })" class="text-gray-400 hover:text-gray-600 transition" title="Copy short URL">'
                                        .'<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>'
                                        .'</button>'
                                        .'</div>'
                                    : '<span class="text-gray-400 text-sm">Type a code above to see the live short URL preview.</span>'
                            )),
                        TextInput::make('target_url')
                            ->label('Target URL')
                            ->required()
                            ->url()
                            ->live()
                            ->helperText('The full URL that fans will be redirected to when they visit /r/{code}. Auto-populated from the selected celebrity\'s portal URL, but you can override this to point anywhere (e.g. a specific event page, ticket sales link, or external social media profile). Must be a valid URL (including https://). Required — if left empty, the redirect will fail.'),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Controls whether the redirect link is currently operational. When ON (default), visiting /r/{code} redirects the user to the target URL. When OFF, the link returns a 404 Not Found response — useful for temporarily disabling a link during promotions or after a campaign ends without deleting the record.'),
                    ]),
            ]);
    }
}
