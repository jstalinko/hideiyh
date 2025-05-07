<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Subscription;

class MySubscription extends Page
{
    protected static ?string $navigationIcon = 'heroicon-c-bell';

    protected static string $view = 'filament.pages.my-subscription';
    protected static ?int $navigationSort = 5;
    public function getViewData(): array
    {
        $activeSubscriptions = Subscription::query()
            ->where('user_id', auth()->user()->id)
            ->where('status', 'active')
            ->with('plan') // Eager load the plan relationship
            ->get();

        return [
            'subscriptions' => $activeSubscriptions,
        ];
    }
}
