<?php

namespace App\Filament\Resources\EstoqueResource\Pages;

use App\Filament\Resources\EstoqueResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Estoque;

class CreateEstoque extends CreateRecord
{
    protected static string $resource = EstoqueResource::class;
    
    protected function afterCreate(): void
    {

    $movimento = $this->record;
    $estoque = Estoque::find($movimento->nome_id);

        if ($estoque) {
            if ($movimento->tipo === 'Entrada') {
            $estoque->increment('quantidade', $movimento->quantidade);
        }   elseif ($movimento->tipo === 'Saida') {
            $estoque->decrement('quantidade', $movimento->quantidade);
            }
        }
    }
}
