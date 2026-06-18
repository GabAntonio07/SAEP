<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->belongsTo (Estoque::class, 'id_rastreio', 'id');
    }
}
