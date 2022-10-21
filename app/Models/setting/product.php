<?php

namespace App\Models\setting;

use App\Models\stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'manufacturer_id', 'description'];

    public function Stock(): HasMany
    {
        return $this->hasMany(stock::class);
    }

    public function Manufacturer(): BelongsTo
    {
        return $this->belongsTo(manufacturer::class);
    }
}
