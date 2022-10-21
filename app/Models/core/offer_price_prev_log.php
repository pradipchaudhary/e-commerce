<?php

namespace App\Models\core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class offer_price_prev_log extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'offer_id'];

    public function Offer(): BelongsTo
    {
        return $this->belongsTo(offer::class);
    }
}
