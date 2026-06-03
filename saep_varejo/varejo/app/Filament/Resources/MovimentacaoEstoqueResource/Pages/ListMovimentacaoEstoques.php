<?php

namespace App\Filament\Resources\MovimentacaoEstoqueResource\Pages;

use App\Filament\Resources\MovimentacaoEstoqueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMovimentacaoEstoques extends ListRecords
{
    protected static string $resource = MovimentacaoEstoqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
