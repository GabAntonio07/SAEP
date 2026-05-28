<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class estoque extends Model
{
    protected $table = 'estoques';

    protected $fillable = [
        'hardware_id',
        'quantidade',
        'data_movimento',
        'tipo'
    ];

    public function hardware(): BelongsTo
    {
        return $this->belongsTo(Hardware::class, 'hardware_id');
    }

}
