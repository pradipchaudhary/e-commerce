<?php

namespace App\Models\setting;

use App\Models\stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class manufacturer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    public function Product(): HasMany
    {
        return $this->hasMany(product::class);
    }

    public function Stock(): HasManyThrough
    {
        return $this->hasManyThrough(stock::class, product::class);
    }
}
