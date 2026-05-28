<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstoqueResource\Pages;
use App\Filament\Resources\EstoqueResource\RelationManagers;
use App\Models\Estoque;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstoqueResource extends Resource
{
    protected static ?string $model = Estoque::class;

    protected static ?string $navigationLabel = 'Movimentos';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('hardware_id')
                    ->relationship('hardware', 'id')
                    ->required(),
                Forms\Components\TextInput::make('quantidade')
                    ->required()
                    ->numeric()
                    ->rules([
                        static function (\Filament\Forms\Get $get): \Closure {
                            return function (string $attribute, $value, \Closure $fail) use ($get) {
                                if ($get('tipo') === 'Saída' && $get('hardware_id')) {
                                    $hardware = \App\Models\Hardware::find($get('hardware_id'));
                                    
                                    if ($hardware && $value > $hardware->quantidade) {
                                        $fail("Quantidade indisponível em estoque! Saldo atual: {$hardware->quantidade}.");
                                    }
                                }
                            };
                        },
                    ]),
                Forms\Components\DatePicker::make('data_movimento')
                    ->required(),
                    Forms\Components\Select::make('tipo')
                    ->options([
                        'Entrada' => 'Entrada',
                        'Saída' => 'Saída',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hardware.id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantidade')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_movimento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListEstoques::route('/'),
            'create' => Pages\CreateEstoque::route('/create'),
            'edit' => Pages\EditEstoque::route('/{record}/edit'),
        ];
    }
}
