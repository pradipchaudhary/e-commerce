<?php

namespace App\Models;

use App\Models\setting\city;
use App\Models\setting\country;
use App\Models\setting\state;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class user_detail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'business_phone_number_code',
        'business_phone_number',
        'whatsapp_code',
        'whatsapp_number',
        'country_id',
        'state_id',
        'address',
        'postal_code',
        'city_id',
        'document',
    ];
    
    public function Country(): BelongsTo
    {
        return $this->belongsTo(country::class);
    }

    public function State() : BelongsTo
    {
        return $this->belongsTo(state::class);
    }

    public function City(): BelongsTo
    {
        return $this->belongsTo(city::class);
    }
}
