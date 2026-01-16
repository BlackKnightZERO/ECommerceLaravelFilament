<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Orders', Order::query()->where('status', 'new')->count()),
            Stat::make('Processing Orders', Order::query()->where('status', 'processing')->count()),
            // Stat::make('Shipped Orders', Order::query()->where('status', 'shipped')->count()),
            // Stat::make('Delivered Orders', Order::query()->where('status', 'delivered')->count()),
            Stat::make('Cancelled Orders', Order::query()->where('status', 'cancelled')->count()),
            // Stat::make('Total Orders', Order::query()->count()),
            Stat::make('Average Price', Order::query()->avg('grand_total')),
            // Stat::make('Total Revenue', Order::query()->sum('grand_total')),
        ];
    }
}
