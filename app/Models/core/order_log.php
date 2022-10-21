<?php

namespace App\Models\core;

use App\Models\shipping_method;
use App\Models\stock;
use App\Models\User;
use App\Models\setting\shipping;
use App\Models\setting\insurance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class order_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stock_id',
        'insurance_id',
        'shipping_id',
        'quantity',
        'price',
        'is_checkout',
        'description',
        'token',
        'is_paid',
        'is_dispatch',
        'is_delivered',
        'is_offer',
        'track_id',
        'shipping_method_id'
    ];

    public function Stock(): BelongsTo
    {
        return $this->belongsTo(stock::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(shipping_method::class);
    }
    
    public function Shipping(): BelongsTo
    {
        return $this->belongsTo(shipping::class);
    }
    
    public function Insurance(): BelongsTo
    {
        return $this->belongsTo(insurance::class);
    }
}
