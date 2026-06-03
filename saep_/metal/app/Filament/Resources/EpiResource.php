<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EpiResource\Pages;
use App\Filament\Resources\EpiResource\RelationManagers;
use App\Models\Epi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EpiResource extends Resource
{
    protected static ?string $model = Epi::class;

    protected static ?string $navigationLabel = 'Epi`s';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('certiicado')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('data_validade')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('certiicado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_validade')
                    ->dateTime()
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
            'index' => Pages\ListEpis::route('/'),
            'create' => Pages\CreateEpi::route('/create'),
            'edit' => Pages\EditEpi::route('/{record}/edit'),
        ];
    }
}
