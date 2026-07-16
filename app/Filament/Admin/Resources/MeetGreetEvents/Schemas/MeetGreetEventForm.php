<?php

namespace App\Filament\Admin\Resources\MeetGreetEvents\Schemas;

use App\Models\Celebrity;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MeetGreetEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Event Details')
                    ->description('Create and manage Meet & Greet events for each celebrity portal. Events can be in-person (at a venue) or virtual (via video call/streaming link). Fans register and purchase tickets for events they want to attend. After creating an event, it will appear on the celebrity\'s fan portal under the Events section. Make sure to set a reasonable capacity, a clear date/time, and mark the event as active once all details are finalized. You can edit events after publishing — changes are reflected immediately for fans. Consider creating events well in advance (2-4 weeks) to give fans time to plan and purchase tickets.')
                    ->columns(['default' => 1, 'sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1, '2xl' => 1])
                    ->schema([
                        Select::make('celebrity_id')
                            ->options(fn () => Celebrity::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->helperText('Select the celebrity who will be hosting this event from the dropdown. Only fans belonging to this celebrity\'s portal will be able to see and register for the event. The list shows all celebrities configured in the system. If the celebrity you need is not listed, first create them in the Celebrities section.'),
                        TextInput::make('title')
                            ->required()
                            ->helperText('The public event name displayed to fans on the portal events page, event cards, and ticket confirmation emails. Make it clear and enticing — e.g. "Summer Fan Meet 2026", "Live Q&A Session", "VIP Dinner with [Celebrity]". Include the year or season if events are recurring. Max 255 characters.'),
                        Textarea::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Full event description displayed on the event detail page. Include what fans can expect: schedule, activities, what to bring, dress code (if any), whether there are photo/autograph opportunities, and any age restrictions or special requirements. The more details you provide, the fewer questions fans will have. Consider including: event format (in-person/virtual), duration, included activities, and what makes this event special.'),
                        DateTimePicker::make('date')
                            ->required()
                            ->helperText('The scheduled date and time for the event. Fans see this in their local timezone (converted automatically). For virtual events, clearly state in the description whether the time is fixed or if recordings will be available. For in-person events, consider including the doors-open time vs event start time in the description. Past events are automatically marked as ended but remain visible in the event history.'),
                        TextInput::make('location')
                            ->required()
                            ->helperText('Physical venue address for in-person events (e.g. "123 Main Street, Los Angeles, CA 90001") or the virtual meeting link for online events (e.g. Zoom, Google Meet, or streaming URL). For physical venues, consider including parking information and nearby landmarks. For virtual events, ensure the link is tested and accessible before publishing.'),
                        TextInput::make('capacity')
                            ->required()
                            ->numeric()
                            ->helperText('Maximum number of tickets/fan registrations available for this event. Set based on venue capacity (in-person) or manageable audience size (virtual). Once this limit is reached, the event shows as "Sold Out" and fans cannot purchase more tickets. Consider leaving some buffer for VIPs or staff. Set to 0 or a very high number (e.g. 9999) for unlimited capacity. For exclusive events, smaller capacities (20-50) create more perceived value.'),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->helperText('Ticket price per person in USD. This overrides the celebrity\'s default meet & greet price if one is set. Enter a numeric value only (e.g. 25.00). Set to 0 for free events. Consider factors: event exclusivity, duration, format (in-person typically costs more than virtual), and any included extras (meal, merchandise, photo). The price is displayed on the event listing and charged at checkout.'),
                        TextInput::make('image_url')
                            ->url()
                            ->helperText('URL to the event promotional image/thumbnail displayed on the events listing page and event detail page. Recommended size: 1200x630px (Facebook/LinkedIn share ratio), JPEG or PNG format. A high-quality, visually appealing image significantly increases ticket sales. Include event branding, date, and the celebrity\'s photo for best results. Use a publicly accessible https URL.'),
                        Toggle::make('is_active')
                            ->required()
                            ->helperText('Controls whether the event is visible and bookable by fans. When active, the event appears on the portal events page and fans can purchase tickets. When inactive, the event is hidden entirely (useful for draft events that are not yet finalized, or events that have been cancelled). Keep inactive while setting up event details, then toggle on once everything is confirmed and ready for public viewing.'),
                    ]),
            ]);
    }
}
