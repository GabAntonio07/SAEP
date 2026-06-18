<?php

namespace App\Filament\Resources\EncomendaResource\Pages;

use App\Filament\Resources\EncomendaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Estoque;

class CreateEncomenda extends CreateRecord
{
    protected static string $resource = EncomendaResource::class;

    protected function afterCreate(): void
    {
        $movimento = $this->record;
        $estoque = Estoque::find($movimento->id_rastreio);

        $qtd = (int) ($movimento->quantidade ?? 0);

        if ($estoque && $qtd > 0) {
            if ($movimento->tipo === 'Entrada') {
                $estoque->increment('quantidade', $qtd);
            } elseif ($movimento->tipo === 'Saida') {
                $estoque->decrement('quantidade', $qtd);
            }
        }
    }
}
