<?php

namespace App\Models\core;

use App\Models\setting\product;
use App\Models\stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'user_id',
        'quantity',
        'status',
        'price',
        'accepted_at',
        'rejected_at',
        'remarks',
    ];

    const STATUS_REJECT = 0;
    const STATUS_ACCEPT = 1;
    const STATUS_PENDING = 2;
    const STATUS_COUNTERED = 3;

    public function Stock(): BelongsTo
    {
        return $this->belongsTo(stock::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function offerPrevPriceLog(): HasMany
    {
        return $this->hasMany(offer_price_prev_log::class);
    }

    public function Product(): HasManyThrough
    {
        return $this->hasManyThrough(product::class, stock::class);
    }
}
