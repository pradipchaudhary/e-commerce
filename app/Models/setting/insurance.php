<?php

namespace App\Models\setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class insurance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['status', 'percent', 'description'];
}
