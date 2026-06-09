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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Cadastro de EPI')
                    ->description('Controle de Equipamentos de Proteção e Validade de CA')
                    ->schema([
                        Forms\Components\TextInput::make('nome')
                        ->required()->maxLength(255),
                        Forms\Components\TextInput::make('codigo')
                        ->label('Código/ID')
                        ->required()
                        ->maxLength(50),
                        Forms\Components\TextInput::make('fabricante')
                        ->label('Fabricante/Fornecedor')->required()
                        ->maxLength(255),
                        Forms\Components\TextInput::make('preco')
                        ->label('Preço (BRL)')
                        ->numeric()
                        ->prefix('R$')
                        ->required(),
                        Forms\Components\TextInput::make('quantidade')
                        ->numeric()
                        ->required(),
                        Forms\Components\TextInput::make('nivel_minimo')
                        ->label('Nível Mínimo para Alerta')
                        ->numeric()
                        ->required(),
                        Forms\Components\TextInput::make('certificado')
                        ->label('CA (Certificado de Aprovação)')
                        ->required()
                        ->maxLength(100),
                        Forms\Components\DatePicker::make('data_validade')
                        ->label('Data de Validade')
                        ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('codigo')
                ->label('Código'),
                Tables\Columns\TextColumn::make('certificado')
                ->label('C.A.'),
                Tables\Columns\TextColumn::make('data_validade')
                ->label('Validade')
                ->date('d/m/Y'),
                
                Tables\Columns\TextColumn::make('quantidade')
                    ->label('Estoque Atual')
                    ->badge()
                    ->color(fn (Model $record): string => 
                        $record->quantidade <= $record->nivel_minimo ? 'danger' : 'success'
                    ),
            ])
            ->defaultSort('nome', 'asc'); 
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
