<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movimento extends Model
{
    protected $fillable = [
        'nome_id',
        'quantidade',
        'data_movimento',
        'tipo',
    ];
}
