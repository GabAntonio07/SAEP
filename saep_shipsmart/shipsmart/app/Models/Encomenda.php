<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    protected $fillable = [
        'id_rastreio',
        'tipo',
        'destinatario',
        'data',
    ];

    public function Estoque(): BelongsTo
    {
        return $this->BelongsTo (Estoque::class, 'codigo');
    }
}
