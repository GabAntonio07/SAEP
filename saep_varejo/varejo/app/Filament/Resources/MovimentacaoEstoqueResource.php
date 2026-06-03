<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimentacaoEstoqueResource\Pages;
use App\Models\MovimentacaoEstoque;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MovimentacaoEstoqueResource extends Resource
{
    protected static ?string $model = MovimentacaoEstoque::class;

    // Configurações de exibição no menu lateral
    protected static ?string $navigationLabel = 'Movimentar Estoque';
    protected static ?string $modelLabel = 'Movimentação';
    protected static ?string $pluralModelLabel = 'Movimentações';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    // FORMULÁRIO DE CADASTRO DE MOVIMENTAÇÃO (Entrada ou Saída)
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Registrar Movimentação de Estoque')
                    ->schema([
                        Forms\Components\Select::make('produto_id')
                            ->label('Selecione o Produto')
                            ->relationship('produto', 'nome')
                            ->required(),
                            
                        Forms\Components\Select::make('tipo')
                            ->label('Tipo de Movimentação')
                            ->options([
                                'Entrada' => 'Entrada',
                                'Saída' => 'Saída',
                            ])
                            ->required(),
                            
                        Forms\Components\TextInput::make('quantidade')
                            ->label('Quantidade Movimentada')
                            ->numeric()
                            ->required(),
                            
                        Forms\Components\DatePicker::make('data_movimentacao')
                            ->label('Data da Movimentação')
                            ->default(now()) 
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('produto.nome')
                    ->label('Produto')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Entrada' ? 'success' : 'danger'),
                    
                Tables\Columns\TextColumn::make('quantidade')
                    ->label('Quantidade')
                    ->numeric(),
                    
                Tables\Columns\TextColumn::make('data_movimentacao')
                    ->label('Data Ocorrência')
                    ->date('d/m/Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')
                    ->label('Filtrar por Tipo')
                    ->options([
                        'Entrada' => 'Entrada',
                        'Saída' => 'Saída',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovimentacaoEstoques::route('/'),
            'create' => Pages\CreateMovimentacaoEstoque::route('/create'),
        ];
    }
}