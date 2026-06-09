<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimentoResource\Pages;
use App\Filament\Resources\MovimentoResource\RelationManagers;
use App\Models\Movimento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovimentoResource extends Resource
{
    protected static ?string $model = Movimento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Registrar Movimentação de Estoque')
                    ->schema([
                        Forms\Components\Select::make('tipo')
                            ->label('Tipo de Movimentação')
                            ->options([
                                'E' => 'Entrada (+)',
                                'S' => 'Saída (-)',
                            ])->required(),

                        Forms\Components\TextInput::make('quantidade')
                            ->label('Quantidade Movimentada')
                            ->numeric()
                            ->required(),

                        Forms\Components\Select::make('liga_id')
                            ->label('Liga Metálica')
                            ->relationship('liga', 'nome'),

                        Forms\Components\Select::make('epi_id')
                            ->label('Equipamento de Proteção (EPI)')
                            ->relationship('epi', 'nome'),

                        Forms\Components\Hidden::make('user_id')
                            ->default(fn () => Auth::id()),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data/Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipo')
                    ->label('Operação')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'E' ? 'Entrada' : 'Saída')
                    ->color(fn (string $state): string => $state === 'E' ? 'success' : 'warning'),

                Tables\Columns\TextColumn::make('quantidade')
                    ->label('Qtd.'),

                Tables\Columns\TextColumn::make('liga.nome')
                    ->label('Liga')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('epi.nome')
                    ->label('EPI')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Operador Responsável'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovimentos::route('/'),
            'create' => Pages\CreateMovimento::route('/create'),
            'edit' => Pages\EditMovimento::route('/{record}/edit'),
        ];
    }
}
