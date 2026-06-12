<?php

namespace App\Filament\Resources\CargaResource\Pages;

use App\Filament\Resources\CargaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCarga extends EditRecord
{
    protected static string $resource = CargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
