<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class state extends Model
{
    use HasFactory;

    public function City(): BelongsTo
    {
        return $this->belongsTo(city::class);
    }
}
