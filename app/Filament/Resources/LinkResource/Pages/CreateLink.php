<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['allowed_country'] = isset($data['allowed_country']) ? json_encode($data['allowed_country']) : json_encode([]);
        $data['allowed_params'] = isset($data['allowed_params']) ? json_encode($data['allowed_params']) : json_encode([]);
        $data['user_id'] = auth()->user()->id;

        // protect with plan
        $data['apikey'] = "XHID-" . strtoupper(md5(uniqid(rand(), true) .auth()->user()->id));
        return $data;
    }
}
