<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;

class Integration extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static string $view = 'filament.pages.integration';

    protected static ?int $navigationSort = 4;

    public function getIntegrations()
    {
        // Filter integrations by the authenticated user's ID
        $integrations= \App\Models\Integration::where('user_id' , auth()->user()->id)->with('link')->get();
        return $integrations;
    }
    public function disconnectIntegration($integrationId)
    {
        // Find the integration
        $integration = \App\Models\Integration::where('id', $integrationId)
            ->where('user_id', auth()->user()->id)
            ->first();
        
        if (!$integration) {
            // Show error notification if integration not found
            Notification::make()
                ->title('Integration not found')
                ->danger()
                ->send();
            
            return;
        }
        
        // Delete the integration
        $integration->delete();
        
        // Show success notification
        Notification::make()
            ->title('Integration disconnected successfully')
            ->success()
            ->send();
    }
}
