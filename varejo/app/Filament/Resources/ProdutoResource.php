<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdutoResource\Pages;
use App\Models\Produto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProdutoResource extends Resource
{
    protected static ?string $model = Produto::class;

    protected static ?string $navigationLabel = 'Produtos';
    protected static ?string $modelLabel = 'Produto';
    protected static ?string $pluralModelLabel = 'Produtos';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações Gerais')
                    ->schema([
                        Forms\Components\TextInput::make('codigo')
                            ->label('Código / ID')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('nome')
                            ->label('Nome do Produto')
                            ->required(),
                        Forms\Components\TextInput::make('fornecedor')
                            ->label('Fabricante / Fornecedor')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Controle de Estoque e Valores')
                    ->schema([
                        Forms\Components\TextInput::make('preco')
                            ->label('Preço')
                            ->numeric()
                            ->prefix('R$')
                            ->required(),
                        Forms\Components\TextInput::make('quantidade')
                            ->label('Quantidade em Estoque')
                            ->numeric()
                            ->required(),
                        
                    Forms\Components\TextInput::make('nivel_minimo') 
                            ->label('Nível Mínimo de Estoque')
                            ->numeric()
                            ->required(),
                    ])->columns(3),
                    
                Forms\Components\Section::make('Especificidades de Giro Rápido (Conveniência)')
                    ->schema([
                        Forms\Components\Select::make('categoria')
                            ->label('Categoria')
                            ->options([
                                'Bebida' => 'Bebida',
                                'Salgado' => 'Salgado',
                                'Doce' => 'Doce',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('data_validade')
                            ->label('Data de Validade')
                            ->required(),
                        Forms\Components\TextInput::make('temperatura_armazenamento')
                            ->label('Temperatura Exigida')
                            ->numeric()
                            ->suffix('°C')
                            ->required(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->label('Código')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categoria')
                    ->label('Categoria'),
                Tables\Columns\TextColumn::make('preco')
                    ->label('Preço')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('quantidade')
                    ->label('Estoque')
                    ->weight('bold')
                    ->color(fn (Produto $record): string => 
                        $record->quantidade <= $record->nivel_minimo ? 'danger' : 'success'
                    )
                        ->icon(fn (Produto $record): ?string => 
                        $record->quantidade <= $record->nivel_minimo ? 'heroicon-m-exclamation-triangle' : null
                    )
                        ->description(fn (Produto $record): string => "Mínimo: {$record->nivel_minimo}"),
                                
                Tables\Columns\TextColumn::make('data_validade')
                    ->label('Data de Validade')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn (Produto $record): string => 
                        $record->data_validade->isPast() || now()->diffInMonths($record->data_validade, false) <= 3
                            ? 'danger'
                            : 'success' 
                    )
                    ->icon(fn (Produto $record): ?string => 
                        $record->data_validade->isPast() || now()->diffInMonths($record->data_validade, false) <= 3
                            ? 'heroicon-m-exclamation-triangle'
                            : null
                    ),

                Tables\Columns\TextColumn::make('temperatura_armazenamento')
                    ->label('Temp. Exigida')
                    ->suffix('°C'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categoria')
                    ->label('Filtrar por Categoria')
                    ->options([
                        'Bebida' => 'Bebida',
                        'Salgado' => 'Salgado',
                        'Doce' => 'Doce',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdutos::route('/'),
            'create' => Pages\CreateProduto::route('/create'),
            'edit' => Pages\EditProduto::route('/{record}/edit'),
        ];
    }
}
