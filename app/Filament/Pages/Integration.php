<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Integration extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static string $view = 'filament.pages.integration';

    protected static ?int $navigationSort = 4;
}
