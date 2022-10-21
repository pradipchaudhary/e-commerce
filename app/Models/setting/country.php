<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'iso',
        'name_woc',
        'iso3',
        'numcode',
        'phonecode'
    ];
}
