<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movimento extends Model
{
    protected $table = 'movimentos';

    protected $fillable = [
        'tipo',
        'quantidade',
        'user_id',
        'liga_id',
        'epi_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function liga(): BelongsTo
    {
        return $this->belongsTo(Liga::class, 'liga_id');
    }

    public function epi(): BelongsTo
    {
        return $this->belongsTo(Epi::class, 'epi_id');
    }
}
