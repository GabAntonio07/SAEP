<?php

namespace App\Filament\Resources\EstoqueResource\Pages;

use App\Filament\Resources\EstoqueResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Hardware;

class CreateEstoque extends CreateRecord
{
    protected static string $resource = EstoqueResource::class;

    protected function afterCreate(): void
    {
        $movimento = $this->record; 
        $hardware = Hardware::find($movimento->hardware_id);

        if ($hardware) {
            if ($movimento->tipo === 'Entrada') {
                $hardware->increment('quantidade', $movimento->quantidade);
            } elseif ($movimento->tipo === 'Saída') {
                $hardware->decrement('quantidade', $movimento->quantidade);
            }
        }
    }
}