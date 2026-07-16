<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Celebrity;
use App\Models\FanApplication;
use App\Models\MeetGreetEvent;
use App\Models\Membership;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return Cache::remember('admin.stats', 300, function () {
            return [
                Stat::make('Total Celebrities', Celebrity::count())
                    ->icon('heroicon-o-user-group')
                    ->description('Active fan portals')
                    ->color('primary'),

                Stat::make('Total Fans', User::where('role', 'fan')->count())
                    ->icon('heroicon-o-users')
                    ->description('Registered fan accounts')
                    ->color('success'),

                Stat::make('Active Memberships', Membership::where('is_active', true)->count())
                    ->icon('heroicon-o-credit-card')
                    ->description('Currently active subscriptions')
                    ->color('warning'),

                Stat::make('Pending Applications', FanApplication::where('status', 'pending')->count())
                    ->icon('heroicon-o-document-text')
                    ->description('Awaiting review')
                    ->color('danger'),

                Stat::make('Upcoming Events', MeetGreetEvent::where('date', '>', now())->where('is_active', true)->count())
                    ->icon('heroicon-o-calendar')
                    ->description('Scheduled meet & greets')
                    ->color('info'),

                Stat::make('Unread Messages', Message::where('is_read', false)->count())
                    ->icon('heroicon-o-envelope')
                    ->description('Messages requiring attention')
                    ->color('gray'),

                Stat::make('Total Orders', Order::count())
                    ->icon('heroicon-o-shopping-cart')
                    ->description('All orders placed')
                    ->color('success'),

                Stat::make('Total Revenue', number_format(Order::sum('amount'), 2))
                    ->icon('heroicon-o-banknotes')
                    ->description('Aggregate revenue')
                    ->color('primary'),
            ];
        });
    }
}
