<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimentacaoEstoque extends Model
{
    protected $table = 'movimentacoes_estoque';

    protected $fillable = [
        'produto_id',
        'tipo',
        'quantidade',
        'data_movimentacao'
    ];

    protected $casts = [
        'data_movimentacao' => 'date',
    ];

    // Relacionamento para o Filament conseguir buscar o nome do produto
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    // LÓGICA AUTOMÁTICA: Atualiza o estoque do produto ao criar a movimentação
    protected static function booted()
    {
        static::created(function ($movimentacao) {
            $produto = $movimentacao->produto;
            
            if ($produto) {
                if ($movimentacao->tipo === 'Entrada') {
                    $produto->increment('quantidade', $movimentacao->quantidade);
                } elseif ($movimentacao->tipo === 'Saída') {
                    $produto->decrement('quantidade', $movimentacao->quantidade);
                }
            }
        });
    }
}
