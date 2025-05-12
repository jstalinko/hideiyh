<?php

namespace App\Filament\Widgets;

use App\Models\Link;
use App\Models\Plan;
use App\Models\User;
use App\Models\Integration;
use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardStatWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total All Traffics' , Link::sum('clicks')),
            
        ];
    }
}
