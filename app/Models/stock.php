<?php

namespace App\Models;

use App\Models\core\cart;
use App\Models\core\esn;
use App\Models\core\offer;
use App\Models\setting\carrier;
use App\Models\setting\color;
use App\Models\setting\grading_scale;
use App\Models\setting\product;
use App\Models\setting\status;
use App\Models\setting\warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_no',
        'product_id',
        'quantity',
        'price',
        'status_id',
        'warehouse_id',
        'carrier_id',
        'color_id',
        'user_id',
        'grading_scale_id',
        'sku',
        'vendor_id',
        'cost_price'
    ];

    public function Product(): BelongsTo
    {
        return $this->belongsTo(product::class);    
    }

    public function Warehouse(): BelongsTo
    {
        return $this->belongsTo(warehouse::class);
    }

    public function Status(): BelongsTo
    {
        return $this->belongsTo(status::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Color(): BelongsTo
    {
        return $this->belongsTo(color::class);
    }

    public function Carrier(): BelongsTo
    {
        return $this->belongsTo(carrier::class);
    }

    public function GradingScale(): BelongsTo
    {
        return $this->belongsTo(grading_scale::class);  
    }

    public function Cart(): HasMany
    {
        return $this->hasMany(cart::class);
    }

    public function Offer()
    {
        return $this->hasMany(offer::class);
    }

    public function Esns(): HasMany
    {
        return $this->hasMany(esn::class);
    }
}
