<?php

namespace App\Filament\Resources\CargaResource\Pages;

use App\Filament\Resources\CargaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Carga;

class CreateCarga extends CreateRecord
{
    protected static string $resource = CargaResource::class;

    protected function afterCreate(): void
    {
    
    $gestao = $this->record;
    $carga = Carga::find($gestao->codigo);

        if ($carga) {
            if ($gestao->tipo === 'entrada') {
                $carga->increment('quantidade', $gestao->quantidade);
            } elseif ($gestao->tipo === 'saida') {
                $carga->decrement('quantidade',  $gestao->quantidade);
            }
        }
    }

}
