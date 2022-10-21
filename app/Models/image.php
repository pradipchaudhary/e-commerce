<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class image extends Model
{
    use HasFactory;

    protected $fillable = ['imageable_id', 'imageable_type', 'name', 'is_banner'];

    public function imageable() : MorphTo
    {
        return $this->morphTo();
    }

    public function getImagePathAttribute()
    {
        return asset('storage/thumbnails/'.$this->name);
    }
}
