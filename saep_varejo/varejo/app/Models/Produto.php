<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'codigo',
        'nome',
        'fornecedor',
        'preco',
        'quantidade',
        'nivel_minimo', 
        'categoria',
        'data_validade',
        'temperatura_armazenamento',
    ];

    protected $casts = [
        'data_validade' => 'date',
    ];

    public function movimentacoes()
    {
        return $this->hasMany(MovimentacaoEstoque::class);
    }
}