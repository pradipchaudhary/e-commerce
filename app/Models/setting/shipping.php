<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class shipping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quantity',
        'name',
        'cost',
        'description'
    ];
}
