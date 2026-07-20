<?php

namespace App\Filament\Admin\Resources\Celebrities\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class CelebrityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Celebrity')
                    ->tabs([
                        Tab::make('Profile')
                            ->schema([
                                Placeholder::make('portal_url')
                                    ->label('Portal URL')
                                    ->content(fn ($record) => $record ? new HtmlString(
                                        '<div class="flex items-center gap-3">'
                                        .'<a href="'.e($record->getPortalUrl()).'" target="_blank" rel="noopener noreferrer" class="font-mono text-sm text-primary-600 hover:text-primary-800 underline">'
                                        .e($record->getPortalUrl())
                                        .'</a>'
                                        .'<button type="button" onclick="navigator.clipboard.writeText(\''.e($record->getPortalUrl()).'\').then(() => { const btn=this; btn.classList.add(\'text-green-500\'); setTimeout(() => btn.classList.remove(\'text-green-500\'), 1500); })" class="text-gray-400 hover:text-gray-600 transition p-1 rounded hover:bg-gray-100" title="Copy portal URL">'
                                        .'<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>'
                                        .'</button>'
                                        .'</div>'
                                    ) : new HtmlString('<span class="text-gray-400 text-sm">Save the celebrity to generate the portal URL.</span>'))
                                    ->visible(fn ($operation) => $operation === 'edit'),
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str($state)->slug()))
                                    ->helperText('The celebrity\'s public display name shown throughout the portal (headings, titles, meta tags). This is also used as the default name in fan-facing pages. Ideally the full stage name.'),
                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('URL slug that determines the portal subdomain: {slug}.'.parse_url(config('app.url'), PHP_URL_HOST).'. Auto-generated from the name but can be customized. Use lowercase letters, numbers, and hyphens only. This cannot be changed after fans have accessed the portal.'),
                                Select::make('category')
                                    ->options(\App\Models\Celebrity::$categories)
                                    ->default('general')
                                    ->live()
                                    ->helperText('The industry category determines the portal\'s visual theme and design vibe. Movie Star = cinematic/red carpet, Country Singer = rustic/warm, Musician = energetic/concert, Adult Star = sleek/premium. Changes take effect immediately on all fan-facing pages.'),
                                Select::make('gender')
                                    ->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'])
                                    ->native(false)
                                    ->placeholder('Select gender')
                                    ->helperText('Displayed on the celebrity directory listing page.'),
                                TextInput::make('country')
                                    ->maxLength(100)
                                    ->placeholder('e.g. United States, United Kingdom, South Korea')
                                    ->helperText('Celebrity\'s country of origin. Shown on the directory listing page.'),
                                TextInput::make('avatar')
                                    ->url()
                                    ->helperText('URL to the celebrity avatar image. Displayed as a circular profile picture on the portal header, sidebar, and fan dashboard. Recommended size: 400x400px minimum, square aspect ratio. Use a publicly accessible image URL (https). Leave empty to auto-generate from initials.'),
                                TextInput::make('cover_photo')
                                    ->url()
                                    ->helperText('URL to the hero/cover banner image displayed at the top of the portal homepage. Recommended size: 1920x600px minimum, landscape orientation. A high-quality professional photo or branded graphic works best. Use a publicly accessible image URL (https).'),
                                Textarea::make('bio')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->helperText('Short biography (max 500 characters) displayed on the portal homepage hero section and About area. Write in third-person perspective. Include the celebrity\'s profession, notable achievements, and a welcoming message for fans. This is the first text fans see when visiting the portal.'),
                                Repeater::make('social_links')
                                    ->schema([
                                        Select::make('platform')
                                            ->options([
                                                'instagram' => 'Instagram',
                                                'twitter' => 'X (Twitter)',
                                                'youtube' => 'YouTube',
                                                'tiktok' => 'TikTok',
                                                'facebook' => 'Facebook',
                                                'website' => 'Website',
                                            ])
                                            ->helperText('Select the social media platform for this link. Available options: Instagram, X (Twitter), YouTube, TikTok, Facebook, and Website. Add one entry per platform — duplicates are not filtered out automatically, so check for duplicates manually.'),
                                        TextInput::make('url')
                                            ->url()
                                            ->helperText('Full URL (including https://) to the celebrity\'s profile on the selected platform. Example: https://instagram.com/username. These links appear as icon buttons on the portal homepage footer and sidebar.'),
                                    ])
                                    ->defaultItems(0)
                                    ->addActionLabel('Add Social Link'),
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Controls whether the portal is publicly accessible. When enabled, fans can visit the subdomain, apply for membership, and browse content. When disabled, visitors see an "under maintenance" or "not available" page. Useful during initial setup or temporary downtime.'),
                            ]),

                        Tab::make('Theme')
                            ->schema([
                                ColorPicker::make('config.theme.primary_color')
                                    ->label('Primary Color')
                                    ->default('#ec4899')
                                    ->helperText('Primary brand color used for all interactive elements: buttons (submit, CTA), hyperlinks, active navigation items, and accent borders throughout the portal. Choose a color that matches the celebrity\'s brand or visual identity. This applies globally across all fan-facing pages.'),
                                ColorPicker::make('config.theme.secondary_color')
                                    ->label('Secondary Color')
                                    ->default('#8b5cf6')
                                    ->helperText('Secondary accent color used for gradients, hover states, badge backgrounds, section highlights, and decorative elements. Typically a complementary or contrasting color to the primary. Works together with the primary color for a cohesive visual theme.'),
                                TextInput::make('config.theme.logo_url')
                                    ->label('Logo URL')
                                    ->url()
                                    ->helperText('URL to the portal logo image. Displayed in the navigation header and page titles. Recommended size: 200x50px, transparent PNG background for best results. If left empty, the celebrity name is shown as text instead. Use a publicly accessible https URL.'),
                                TextInput::make('config.theme.cover_url')
                                    ->label('Cover URL')
                                    ->url()
                                    ->helperText('URL to the portal hero background/cover image. Displayed behind the main hero section on the homepage. Recommended size: 1920x800px, dark or medium-toned images work best since text overlays are displayed on top. Falls back to the profile cover_photo if this is not set.'),

                                Select::make('config.theme.background_type')
                                    ->label('Page Background')
                                    ->options([
                                        'mesh' => 'Mesh Gradient',
                                        'solid' => 'Solid Color',
                                        'image' => 'Background Image',
                                    ])
                                    ->default('mesh')
                                    ->helperText('Choose the overall page background style for the entire portal. "Mesh Gradient" uses the primary and secondary colors to create a dynamic ambient gradient. "Solid Color" fills the background with a single flat color. "Background Image" covers the page with a custom image.'),
                                ColorPicker::make('config.theme.background_color')
                                    ->label('Background Color')
                                    ->default('#ffffff')
                                    ->helperText('The base background color used when "Solid Color" is selected above, or as the fallback color beneath gradient and image backgrounds. Pick a color that complements the celebrity\'s brand and ensures content readability. Defaults to white.'),
                                TextInput::make('config.theme.background_image_url')
                                    ->label('Background Image URL')
                                    ->url()
                                    ->placeholder('https://example.com/background.jpg')
                                    ->helperText('URL to a full-page background image, used when "Background Image" is selected above. Recommended: 1920x1080px or larger, dark or blurred images work best so text overlays remain readable. The image will cover the entire page and scroll with content. Use a publicly accessible https URL.'),
                            ]),

                        Tab::make('Site Content')
                            ->schema([
                                TextInput::make('config.site_content.hero_title')
                                    ->label('Hero Title')
                                    ->placeholder('Welcome to the Fan Community')
                                    ->helperText('The main headline text displayed prominently in the hero section at the top of the portal homepage. This is the first thing visitors see. Keep it concise and compelling — e.g. "Welcome to the Official Fan Community" or "Join the Inner Circle". Recommended: 3-8 words.'),
                                TextInput::make('config.site_content.hero_subtitle')
                                    ->label('Hero Subtitle')
                                    ->placeholder('Join the most exclusive fan community.')
                                    ->helperText('Supporting text displayed directly below the hero title. Provides additional context or a call-to-action, e.g. "Get exclusive access to content, events, and community." Recommended: 10-25 words. Leave empty to show only the hero title.'),
                                TextInput::make('config.site_content.about_title')
                                    ->label('About Title')
                                    ->helperText('Heading label for the About section on the portal homepage, e.g. "About [Celebrity Name]", "The Story", or "Meet the Star". This section typically appears below the hero area and gives new visitors context about who the celebrity is.'),
                                Textarea::make('config.site_content.about_body')
                                    ->label('About Text')
                                    ->rows(4)
                                    ->helperText('The main body text for the About section. Write a fuller biography, career highlights, and why fans should join the community. This is the primary content that helps convert new visitors into members. Can include multiple paragraphs. Recommended: 100-300 words for best engagement.'),
                                Repeater::make('config.site_content.testimonials')
                                    ->label('Testimonials')
                                    ->schema([
                                        TextInput::make('author')
                                            ->required()
                                            ->helperText('Full name or social media handle of the fan giving the testimonial. This is displayed publicly on the portal homepage. Use real fan names with their permission for authenticity. Example: "Sarah J." or "@kpopfan88".'),
                                        TextInput::make('quote')
                                            ->required()
                                            ->helperText('The actual testimonial quote from the fan, displayed in a styled card on the homepage. Keep it concise and genuine — 1-3 sentences is ideal. Example: "Being part of this community has been incredible. I\'ve made so many friends and the exclusive content is amazing!"'),
                                        TextInput::make('badge')
                                            ->label('Badge (e.g. Gold Member)')
                                            ->helperText('A label or badge title displayed next to the testimonial author name, indicating their membership status or tier, e.g. "Gold Member", "Platinum Fan", "Top Supporter". This helps social proof by showing that real members are endorsing the community. Optional — leave empty for no badge.'),
                                    ])
                                    ->defaultItems(0)
                                    ->addActionLabel('Add Testimonial'),
                            ]),

                        Tab::make('Membership Tiers')
                            ->schema([
                                Section::make('Tiers')
                                    ->description('Define the subscription/membership tiers available to fans on this portal. Tiers are displayed on the pricing page and fans choose one when applying. Drag to reorder — the first tier appears as the most prominent option. Each tier must have a name and price; benefits are optional but recommended for conversion. Typically set 2-4 tiers (e.g. Bronze, Silver, Gold, Platinum) with increasing price and perks.')
                                    ->schema([
                                        Repeater::make('config.membership_tiers')
                                            ->schema([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(100)
                                                    ->helperText('Display name for this membership tier, e.g. "Bronze", "Silver", "Gold", "Platinum", or "VIP". Shown on the pricing page, membership cards, and fan dashboard. Use tier names that create perceived value progression. Max 100 characters.'),
                                                TextInput::make('price')
                                                    ->required()
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->helperText('The recurring price for this membership tier in USD. Enter a numeric value only (e.g. 9.99). This is the amount fans will be charged. Set to 0 for a free tier. Consider the market and the celebrity\'s audience when pricing — lower tiers should be accessible, higher tiers can include premium perks.'),
                                                TextInput::make('color')
                                                    ->placeholder('#C0C0C0')
                                                    ->helperText('Hex color code that visually distinguishes this tier, used for the tier badge, card accent, and UI elements throughout the portal. Matches the tier naming convention — e.g. #CD7F32 for Bronze, #C0C0C0 for Silver, #FFD700 for Gold, #E5E4E2 for Platinum. Enter without the # prefix.'),
                                                TagsInput::make('benefits')
                                                    ->placeholder('Add benefit')
                                                    ->helperText('List of individual perks/benefits included with this membership tier. Each entry is displayed as a bullet point on the pricing page. Examples: "Exclusive monthly photos", "Behind-the-scenes videos", "Priority access to events", "Personalized welcome message". Add 3-7 benefits per tier for best conversion. Press Enter or type a comma to add each item.'),
                                            ])
                                            ->defaultItems(0)
                                            ->addActionLabel('Add Tier')
                                            ->reorderable()
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('Payment Methods')
                            ->schema([
                                Section::make('Payment Methods')
                                    ->description('Configure the payment methods fans can use to pay for membership applications, event tickets, and membership cards. Add one or more methods — fans will see all enabled methods at checkout and can choose their preferred one. For each method, provide accurate details (bank account, crypto wallet, etc.) and clear instructions so fans can complete payment successfully. Test each method after adding to verify the flow. Stripe is recommended as the primary method for automatic payment processing.')
                                    ->schema([
                                        Repeater::make('paymentMethods')
                                            ->relationship('paymentMethods')
                                            ->schema([
                                                Select::make('type')
                                                    ->label('Method Type')
                                                    ->options([
                                                        'stripe' => 'Credit/Debit Card (Stripe)',
                                                        'bank_transfer' => 'Bank Transfer',
                                                        'paypal' => 'PayPal',
                                                        'cryptocurrency' => 'Cryptocurrency',
                                                        'offline' => 'Offline / Custom',
                                                    ])
                                                    ->live()
                                                    ->helperText('Select the type of payment method. "Credit/Debit Card (Stripe)" processes payments automatically via Stripe — fans pay online instantly. "Bank Transfer" provides your bank details for manual transfers. "PayPal" uses the fan\'s PayPal account. "Cryptocurrency" accepts crypto wallet payments. "Offline / Custom" is for any other method like cash, Venmo, GCash, etc. The type determines which additional fields appear below.'),
                                                TextInput::make('label')
                                                    ->label('Display Label')
                                                    ->maxLength(255)
                                                    ->helperText('A human-readable label shown to fans at checkout, e.g. "Credit Card", "Bank Transfer (Wire)", "Bitcoin", "GCash". Pick a clear, recognizable name so fans know exactly what payment method they are selecting. Max 255 characters.'),
                                                TextInput::make('details.bank_name')
                                                    ->label('Bank Name')
                                                    ->visible(fn ($get) => $get('type') === 'bank_transfer')
                                                    ->helperText('Full legal name of the bank where the account is held. This is displayed to fans so they know where to send the transfer. Example: "Chase Bank" or "Bank of America". Required for bank transfer method.'),
                                                TextInput::make('details.account_number')
                                                    ->label('Account Number')
                                                    ->visible(fn ($get) => $get('type') === 'bank_transfer')
                                                    ->helperText('The bank account number where fans should send payments. Keep this secure — it is displayed to fans who select bank transfer at checkout. Double-check for accuracy to ensure payments arrive correctly. For international transfers, include the IBAN if applicable.'),
                                                TextInput::make('details.account_name')
                                                    ->label('Account Name')
                                                    ->visible(fn ($get) => $get('type') === 'bank_transfer')
                                                    ->helperText('Full legal name of the account holder as registered with the bank. This helps fans verify they are sending to the correct recipient. Match exactly what appears on the bank statement.'),
                                                TextInput::make('details.routing_number')
                                                    ->label('Routing Number')
                                                    ->visible(fn ($get) => $get('type') === 'bank_transfer')
                                                    ->helperText('The 9-digit routing/ABA number for the bank. Required for domestic wire transfers within the US. Fans need this to route the payment correctly. Example format: 021000021.'),
                                                TextInput::make('details.swift_code')
                                                    ->label('SWIFT / BIC Code')
                                                    ->visible(fn ($get) => $get('type') === 'bank_transfer')
                                                    ->helperText('The SWIFT/BIC code for international wire transfers (8-11 alphanumeric characters). Required if fans may send payments from outside the country. Example: BOFAUS3N. Check with your bank for the correct code if unsure.'),
                                                TextInput::make('details.email')
                                                    ->label('PayPal Email')
                                                    ->visible(fn ($get) => $get('type') === 'paypal')
                                                    ->email()
                                                    ->helperText('The email address associated with your PayPal business account where payments should be sent. Fans will be redirected to PayPal to complete payment using this email. Use a verified business PayPal account for automatic payment confirmation.'),
                                                TextInput::make('details.wallet_address')
                                                    ->label('Wallet Address')
                                                    ->visible(fn ($get) => $get('type') === 'cryptocurrency')
                                                    ->live(onBlur: true)
                                                    ->helperText('The cryptocurrency wallet address where fans send payments. Ensure this address matches the selected blockchain network (e.g. a BTC address for Bitcoin network, ETH address for Ethereum). A QR code is auto-generated from this address for fans to scan. Double-check the address is correct — crypto transactions are irreversible.'),
                                                Placeholder::make('details.qr_preview')
                                                    ->label('QR Code Preview')
                                                    ->visible(fn ($get) => filled($get('type')) && $get('type') === 'cryptocurrency' && filled($get('details.wallet_address')))
                                                    ->content(fn ($get) => new HtmlString(
                                                        '<div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">'.
                                                        '<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.urlencode($get('details.wallet_address') ?? '').'" alt="QR Code" style="border-radius:8px;width:150px;height:150px" />'.
                                                        '<div class="text-xs text-gray-500">'.
                                                        '<p class="font-semibold text-gray-700 mb-1">Scan to pay</p>'.
                                                        '<p class="break-all">'.e($get('details.wallet_address') ?? '').'</p>'.
                                                        '</div>'.
                                                        '</div>'
                                                    )),
                                                Select::make('details.network')
                                                    ->label('Blockchain Network')
                                                    ->options([
                                                        'bitcoin' => 'Bitcoin (BTC)',
                                                        'ethereum' => 'Ethereum (ETH)',
                                                        'solana' => 'Solana (SOL)',
                                                        'usdt_erc20' => 'USDT (ERC-20)',
                                                        'usdt_trc20' => 'USDT (TRC-20)',
                                                        'bnb' => 'BNB Smart Chain',
                                                        'polygon' => 'Polygon (MATIC)',
                                                    ])
                                                    ->visible(fn ($get) => $get('type') === 'cryptocurrency')
                                                    ->helperText('Select the blockchain/network for the cryptocurrency wallet address. This must match the actual wallet address — sending BTC to an ETH address will result in permanent loss of funds. Options: Bitcoin (BTC), Ethereum (ETH), Solana (SOL), USDT (ERC-20), USDT (TRC-20), BNB Smart Chain, Polygon (MATIC).'),
                                                TextInput::make('details.custom_label')
                                                    ->label('Custom Label')
                                                    ->visible(fn ($get) => $get('type') === 'offline')
                                                    ->helperText('A custom label for your offline/alternative payment method. Examples: "GCash", "Venmo (@username)", "Cash at Venue", "Bank Transfer (Local)". This is displayed as the payment option name at checkout, so use a name fans will recognize.'),
                                                RichEditor::make('details.instructions')
                                                    ->label('Payment Instructions')
                                                    ->visible(fn ($get) => $get('type') !== 'stripe')
                                                    ->helperText('Detailed step-by-step instructions displayed to fans when they select this payment method at checkout. Include specific details the fan needs: what information to include in the transfer reference, where to send the payment confirmation/receipt, expected processing time, and any follow-up steps. Use rich text formatting for clarity. Example: "Please include your full name in the transfer reference. After sending, email a screenshot of the receipt to payments@example.com."'),
                                                Toggle::make('enabled')
                                                    ->default(true)
                                                    ->helperText('Enable or disable this payment method. Disabled methods are not shown to fans at checkout. Useful for temporarily pausing a method (e.g. bank transfer during holidays) without deleting the configuration. When creating a new method, enable it after verifying all details are correct.'),
                                            ])
                                            ->defaultItems(0)
                                            ->addActionLabel('Add Payment Method')
                                            ->reorderable()
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('Pricing')
                            ->schema([
                                Section::make('Fan Application Fee')
                                    ->description('Set the one-time, non-refundable fee that fans must pay when they submit a membership application. This is charged regardless of whether the application is approved or rejected — it covers the cost of processing. Set to $0 for free applications. If you charge a fee, ensure you have at least one payment method configured in the Payment Methods tab so fans can complete payment.')
                                    ->schema([
                                        TextInput::make('config.pricing.fan_application_fee')
                                            ->label('Application Fee')
                                            ->numeric()
                                            ->prefix('$')
                                            ->default(0)
                                            ->helperText('The application fee amount in USD. Fans pay this when submitting a membership application. Use 0 for free applications (recommended for higher conversion). Typical range: $0-$25. This fee is shown on the application form and collected before the application is reviewed.'),
                                    ]),
                                Section::make('Membership Card Fee')
                                    ->description('Set the one-time fee fans pay when ordering a membership card (physical or digital). This is separate from the membership tier price — fans pay this once when they decide to get a card. The card serves as a collectible and status symbol within the community. Set to $0 to offer free cards (cost covered by membership fees). If charging, typical range is $5-$25 for digital cards and $10-$50 for physical cards (shipping included).')
                                    ->schema([
                                        TextInput::make('config.pricing.membership_card_fee')
                                            ->label('Card Fee')
                                            ->numeric()
                                            ->prefix('$')
                                            ->default(0)
                                            ->helperText('The one-time card fee in USD. Fans pay this when ordering a membership card through their dashboard. Set to 0 to offer cards for free (the cost is absorbed into the membership tier price). Consider production and shipping costs if offering physical cards.'),
                                    ]),
                                Section::make('Meet & Greet Default Price')
                                    ->description('Set the default ticket price that is pre-filled automatically when you create a new Meet & Greet event in the Meet & Greet Events section. This is a convenience setting — you can override the price on each individual event. Helps maintain consistent pricing across events without manually re-entering the same amount each time.')
                                    ->schema([
                                        TextInput::make('config.pricing.meet_greet_default_price')
                                            ->label('Default Ticket Price')
                                            ->numeric()
                                            ->prefix('$')
                                            ->default(0)
                                            ->helperText('Default ticket price in USD that auto-populates the price field when creating a new Meet & Greet event. Adjust per event as needed. Set to 0 if most events are free. Typical range: $10-$200 depending on exclusivity and format (in-person vs virtual).'),
                                    ]),
                                Section::make('Private Meetup Pricing')
                                    ->description('Define the available durations and their prices for private 1-on-1 meetups with the celebrity. Fans select a duration when booking, and the system calculates the total. Offer at least 2-3 duration options to give fans flexibility. Shorter sessions (30 min) work well as an entry-level option, while longer sessions (90-120 min) can include premium features like signed memorabilia or extended Q&A. Drag to reorder — the first option appears as the default/featured choice.')
                                    ->schema([
                                        Repeater::make('config.pricing.private_meetup')
                                            ->schema([
                                                Select::make('duration')
                                                    ->label('Duration (minutes)')
                                                    ->options([
                                                        30 => '30 min',
                                                        60 => '60 min',
                                                        90 => '90 min',
                                                        120 => '120 min',
                                                    ])
                                                    ->required()
                                                    ->helperText('Length of the private meetup session in minutes. Options available: 30 min (quick chat/photo), 60 min (standard session), 90 min (extended), 120 min (premium experience). Choose the duration that matches what you offer for this price tier.'),
                                                TextInput::make('price')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->required()
                                                    ->helperText('Price in USD for this meetup duration. Longer sessions should be priced higher. Consider the celebrity\'s time and the exclusivity of private access. Example range: $50-$100 for 30 min, $100-$200 for 60 min, $200-$500 for premium sessions. Set competitive but sustainable pricing.'),
                                            ])
                                            ->defaultItems(4)
                                            ->addActionLabel('Add Duration')
                                            ->reorderable()
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('Features')
                            ->schema([
                                Section::make('Enable/Disable Features')
                                    ->description('Toggle entire feature sections on/off for this celebrity portal. Disabled features are completely hidden from fans — they won\'t see navigation links, menu items, or any UI related to that feature. Use this to simplify the portal (e.g. disable Private Meetups if the celebrity doesn\'t offer them) or to phase features in gradually. All features are enabled by default. Note: disabling a feature does not delete associated data (events, messages, etc.) — it only hides them from the fan-facing interface.')
                                    ->schema([
                                        Toggle::make('config.features.fan_applications')
                                            ->label('Fan Applications')
                                            ->default(true),
                                        Toggle::make('config.features.membership')
                                            ->label('Membership')
                                            ->default(true),
                                        Toggle::make('config.features.meet_greet')
                                            ->label('Meet & Greet Events')
                                            ->default(true),
                                        Toggle::make('config.features.membership_card')
                                            ->label('Membership Cards')
                                            ->default(true),
                                        Toggle::make('config.features.private_meetup')
                                            ->label('Private Meetups')
                                            ->default(true),
                                        Toggle::make('config.features.messaging')
                                            ->label('Messaging')
                                            ->default(true),
                                    ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
