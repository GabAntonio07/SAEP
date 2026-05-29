<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movimento extends Model
{
    protected $fillable = [
        'nome_id',
        'tipo',
        'data_movimento',
        'quantidade'
    ];

    public function movimento()
    {
        return $this->hasMany(Estoque::class);
    }
}
