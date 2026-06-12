<?php

namespace App\Filament\Resources\CargaResource\Pages;

use App\Filament\Resources\CargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCargas extends ListRecords
{
    protected static string $resource = CargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
