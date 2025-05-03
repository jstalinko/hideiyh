<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MySubscription extends Page
{
    protected static ?string $navigationIcon = 'heroicon-c-bell';

    protected static string $view = 'filament.pages.my-subscription';
    protected static ?int $navigationSort = 5;
}
