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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('codigo')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('fabricante')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('preco')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('quantidade')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nivel_minimo')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('numero_de_serie')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('tempo_de_vida')
                    ->required(),
                Forms\Components\TextInput::make('localizacao')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fabricante')
                    ->searchable(),
                Tables\Columns\TextColumn::make('preco')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantidade')
                    ->numeric()
                    ->sortable()
                    ->label('quantidade')
                    ->badge()
                    ->color (function ($record){
                        if ($record->quantidade == 0){
                            return 'danger';
                        } if ($record->quantidade < $record->nivel_minimo){
                            return 'warning';
                        }
                        return 'success';
                    }),
                Tables\Columns\TextColumn::make('nivel_minimo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('numero_de_serie')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tempo_de_vida')
                    ->dateTime()
                    ->sortable()
                    ->color(function ($record) {
                        $cadastro = \Carbon\Carbon::parse($record->tempo_de_vida);

                        $tempoAtual = now();
                        
                        $limiteDozeHoras = $cadastro->copy()->addHours(12);
                        $limiteDezHoras = $cadastro->copy()->addHours(10);

                        if ($tempoAtual > $limiteDozeHoras) {
                            return 'danger';
                        } 
                        
                        if ($tempoAtual > $limiteDezHoras) {
                            return 'warning'; 
                        } 

                        return 'success'; 
                    }),
                /*Tables\Columns\TextColumn::make('tempo_de_vida')
                    ->dateTime()
                    ->sortable()
                    ->color(function ($record) {
                        $cadastro = \Carbon\Carbon::parse($record->tempo_de_vida);
                        $tempoAtual = now();
                        
                        $limiteDozeHoras = $cadastro->copy()->addHours(12);
                        $limiteDezHoras = $cadastro->copy()->addHours(10);

                        if ($tempoAtual > $limiteDozeHoras) {
                            return 'danger';
                        } 
                        if ($tempoAtual > $limiteDezHoras) {
                            return 'warning';
                        } 
                        return 'success';
                    })
                    ->description(function ($record) {
                        $cadastro = \Carbon\Carbon::parse($record->tempo_de_vida);
                        $tempoAtual = now();
                        $limiteDozeHoras = $cadastro->copy()->addHours(12);

                        if ($tempoAtual < $limiteDozeHoras) {
                            $horasRestantes = $tempoAtual->diffInHours($limiteDozeHoras);
                            $minutosRestantes = $tempoAtual->diffInMinutes($limiteDozeHoras) % 60;

                            return "Resta(m): {$horasRestantes}h e {$minutosRestantes}min";
                        }

                        $horasAtrasadas = $limiteDozeHoras->diffInHours($tempoAtual);
                        return "Excedido há {$horasAtrasadas}h";
                    }),*/
                Tables\Columns\TextColumn::make('localizacao')
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
