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
        $cacheKey = 'admin.stats_data.'.md5_file(base_path('composer.lock'));

        $data = Cache::remember($cacheKey, 300, function () {
            return [
                ['label' => 'Total Celebrities', 'value' => Celebrity::count(), 'icon' => 'heroicon-o-user-group', 'desc' => 'Active fan portals', 'color' => 'primary'],
                ['label' => 'Total Fans', 'value' => User::where('role', 'fan')->count(), 'icon' => 'heroicon-o-users', 'desc' => 'Registered fan accounts', 'color' => 'success'],
                ['label' => 'Active Memberships', 'value' => Membership::where('is_active', true)->count(), 'icon' => 'heroicon-o-credit-card', 'desc' => 'Currently active subscriptions', 'color' => 'warning'],
                ['label' => 'Pending Applications', 'value' => FanApplication::where('status', 'pending')->count(), 'icon' => 'heroicon-o-document-text', 'desc' => 'Awaiting review', 'color' => 'danger'],
                ['label' => 'Upcoming Events', 'value' => MeetGreetEvent::where('date', '>', now())->where('is_active', true)->count(), 'icon' => 'heroicon-o-calendar', 'desc' => 'Scheduled meet & greets', 'color' => 'info'],
                ['label' => 'Unread Messages', 'value' => Message::where('is_read', false)->count(), 'icon' => 'heroicon-o-envelope', 'desc' => 'Messages requiring attention', 'color' => 'gray'],
                ['label' => 'Total Orders', 'value' => Order::count(), 'icon' => 'heroicon-o-shopping-cart', 'desc' => 'All orders placed', 'color' => 'success'],
                ['label' => 'Total Revenue', 'value' => number_format(Order::sum('amount'), 2), 'icon' => 'heroicon-o-banknotes', 'desc' => 'Aggregate revenue', 'color' => 'primary'],
            ];
        });

        return array_map(fn ($d) => Stat::make($d['label'], $d['value'])
            ->icon($d['icon'])
            ->description($d['desc'])
            ->color($d['color']), $data);
    }
}
