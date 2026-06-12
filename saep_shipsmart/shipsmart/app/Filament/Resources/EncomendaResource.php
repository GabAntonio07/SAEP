<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EncomendaResource\Pages;
use App\Filament\Resources\EncomendaResource\RelationManagers;
use App\Models\Encomenda;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EncomendaResource extends Resource
{
    protected static ?string $model = Encomenda::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_rastreio')
                    ->required()
                    ->relationship(['Estoque', 'nome'])
                    ->numeric(),
                Forms\Components\Select::make('tipo')
                    ->required()
                    ->options([
                        'Entrada' => 'entrada',
                        'Saída' => 'saida'
                        ]),
                Forms\Components\TextInput::make('destinatario')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('data')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_rastreio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('tipo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('destinatario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListEncomendas::route('/'),
            'create' => Pages\CreateEncomenda::route('/create'),
            'edit' => Pages\EditEncomenda::route('/{record}/edit'),
        ];
    }
}
