<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Models\Link;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\LinkResource;
use Illuminate\Support\Facades\Storage;

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
    
  
}