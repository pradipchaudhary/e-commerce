<?php

namespace App\Models\core;

use App\Models\stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['stock_id', 'quantity', 'user_id'];

    public function Stock(): BelongsTo
    {
        return $this->belongsTo(stock::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderLog(): HasMany
    {
        return $this->hasMany(order_log::class);
    }
}
