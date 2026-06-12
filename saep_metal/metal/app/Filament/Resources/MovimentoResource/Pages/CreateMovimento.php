<?php

namespace App\Filament\Resources\MovimentoResource\Pages;

use App\Filament\Resources\MovimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimento extends CreateRecord
{
    protected static string $resource = MovimentoResource::class;

protected function afterCreate(): void
{
    $move = $this->record;

    if ($move->epi_id) {
        $epi = \App\Models\epi::find($move->epi_id); 

        if ($epi) {
            if ($move->tipo === 'Entrada') {
                $epi->increment('quantidade', $move->quantidade);
            } elseif ($move->tipo === 'Saída') {
                $epi->decrement('quantidade', $move->quantidade);
            }
        }
    }

    if ($move->liga_id) {
        $liga = \App\Models\liga::find($move->liga_id); 

        if ($liga) {
            if ($move->tipo === 'Entrada') {
                $liga->increment('quantidade', $move->quantidade);
            } elseif ($move->tipo === 'Saída') {
                $liga->decrement('quantidade', $move->quantidade);
            }
        }
    }
}
}