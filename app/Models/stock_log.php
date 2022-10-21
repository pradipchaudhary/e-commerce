<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class stock_log extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'stock_id',
        'quantity',
        'price',
        'is_out',
        'user_id',
    ];

    public function Stock(): BelongsTo
    {
        return $this->belongsTo(stock::class);
    }
}
