<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Models\Link;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\LinkResource;
use Filament\Notifications\Notification;
use Filament\Support\Enums\IconPosition;

class StatsLink extends Page
{
    protected static string $resource = LinkResource::class;
    
    protected static string $view = 'filament.resources.link-resource.pages.stats-link';
    
    public ?Link $record = null;
    public ?string $logs_data = null;
    public static string $routeParameterName = 'record';
    
    public function mount(Link $record): void
    {
        $logPath = storage_path('logs/links/user-' . $record->user_id . '_link-' . $record->id . '.log');
    
    // Check if the log file exists
    if (file_exists($logPath)) {
        $this->logs_data = file_get_contents($logPath);
    } else {
        // Set a default value or message if the log doesn't exist
        $this->logs_data = "No logs found for this link. $logPath";
    }
    
        $this->record = $record;
       

    }
    public function getMaxWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }



    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh Data')
                ->icon('heroicon-o-arrow-path')
                ->iconPosition(IconPosition::After)
                ->action(fn () => $this->refresh()),
            Action::make('reset')
               ->color('danger')
                ->label('Reset stats')
                ->icon('heroicon-o-arrow-path')
                ->iconPosition(IconPosition::After)
                ->action(fn () => $this->resetData()),
        ];
    }
    public function resetData(): void
    {
        // Logic to reset the data
        $this->record->update([
            'clicks' => 0,
            'white_page_clicks' => 0,
            'bot_page_clicks' => 0,
            'offer_page_clicks' => 0,
        ]);
        Notification::make()
            ->title('Data reset successfully!')
            ->success()
            ->send();
    }
    public function refresh(): void
    {
        // Logic to refresh the data
        $this->record->refresh();
        Notification::make()
            ->title('Data refreshed successfully!')
            ->success()
            ->send();
    }

    public function getViewData(): array
    {
        $record = $this->record;
        // Fetch click metrics from your database
        // You'll need to adjust these queries based on your actual database structure
        $totalClicks = $record->clicks;
        $offerClicks = $record->offer_page_clicks;
        $botClicks = $record->bot_page_clicks;
        $whiteClicks = $record->white_page_clicks;

        // Calculate percentages for display
        $offerPercentage = $totalClicks > 0 ? round(($offerClicks / $totalClicks) * 100) : 0;
        $botPercentage = $totalClicks > 0 ? round(($botClicks / $totalClicks) * 100) : 0;
        $whitePercentage = $totalClicks > 0 ? round(($whiteClicks / $totalClicks) * 100) : 0;

        return [
            'totalClicks' => $totalClicks,
            'offerClicks' => $offerClicks,
            'botClicks' => $botClicks,
            'whiteClicks' => $whiteClicks,
            'offerPercentage' => $offerPercentage,
            'botPercentage' => $botPercentage,
            'whitePercentage' => $whitePercentage,
        ];
    }
    
  
}