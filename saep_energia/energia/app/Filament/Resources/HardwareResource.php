<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HardwareResource\Pages;
use App\Filament\Resources\HardwareResource\RelationManagers;
use App\Models\Hardware;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HardwareResource extends Resource
{
    protected static ?string $model = Hardware::class;

    protected static ?string $navigationLabel = 'Hardwares';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('codigo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('fabricante')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantidade')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nivel_minimo')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('end_mac')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('end_ip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('voltagem')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('manutencao')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fabricante')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantidade')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => $record->quantidade <= $record->nivel_minimo ? 'danger' : 'success')
                    ->icon(fn ($record) => $record->quantidade <= $record->nivel_minimo ? 'heroicon-m-exclamation-triangle' : null),
                Tables\Columns\TextColumn::make('nivel_minimo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_mac')
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_ip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('voltagem')
                    ->searchable(),
                Tables\Columns\TextColumn::make('manutencao')
                    ->dateTime('d/m/Y H:i') 
                    ->sortable()
                    ->badge() 
                    ->color(fn ($record) => $record->manutencao && now()->subMonths(6)->greaterThan($record->manutencao) ? 'danger' : 'success')
                    ->icon(fn ($record) => $record->manutencao && now()->subMonths(6)->greaterThan($record->manutencao) ? 'heroicon-m-exclamation-triangle' : null),
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
            'index' => Pages\ListHardware::route('/'),
            'create' => Pages\CreateHardware::route('/create'),
            'edit' => Pages\EditHardware::route('/{record}/edit'),
        ];
    }
}
