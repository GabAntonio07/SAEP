<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LigaResource\Pages;
use App\Filament\Resources\LigaResource\RelationManagers;
use App\Models\Liga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LigaResource extends Resource
{
    protected static ?string $model = Liga::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Cadastro de Liga Metálica')
                    ->description('Campos obrigatórios e especificações técnicas da fundição')
                    ->schema([
                        Forms\Components\TextInput::make('nome')
                        ->required()
                        ->maxLength(255),
                        Forms\Components\TextInput::make('codigo')
                        ->label('Código/ID')
                        ->required()
                        ->maxLength(50),
                        Forms\Components\TextInput::make('fabricante')
                        ->label('Fabricante/Fornecedor')
                        ->required()
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
                        Forms\Components\TextInput::make('tipo_liga')
                        ->label('Tipo de Liga')->required()->maxLength(100),
                        Forms\Components\TextInput::make('ponto_fusao')
                        ->label('Ponto de Fusão (°C)')->numeric()->required(),
                        Forms\Components\TextInput::make('peso_toneladas')
                        ->label('Peso (Toneladas)')->numeric()->required(),
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
                Tables\Columns\TextColumn::make('tipo_liga')
                ->label('Tipo'),
                Tables\Columns\TextColumn::make('ponto_fusao')
                ->label('P. Fusão (°C)'),
                
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
            'index' => Pages\ListLigas::route('/'),
            'create' => Pages\CreateLiga::route('/create'),
            'edit' => Pages\EditLiga::route('/{record}/edit'),
        ];
    }
}
