<?php

namespace App\Filament\Resources\EpiResource\Pages;

use App\Filament\Resources\EpiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEpi extends EditRecord
{
    protected static string $resource = EpiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
