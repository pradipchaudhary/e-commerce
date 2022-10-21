<?php

namespace App\Models\setting;

use App\Models\image;
use App\Models\stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class grading_scale extends Model
{
    use HasFactory,SoftDeletes;

    const NAMESPACE = 'App\Models\setting\grading_scale';
    
    protected $fillable = [
        'name',
        'grade_id',
        'apperance',
        'screen',
        'bezel',
        'other',
        'functionality',
        'lcd',
        'entered_by'
    ];

    public function Grade(): BelongsTo
    {
        return $this->belongsTo(grade::class);
    }

    public function Stock(): HasMany
    {
        return $this->hasMany(stock::class);    
    }

    public function images(): MorphMany
    {
        return $this->morphMany(image::class,'imageable');
    }
}
