<?php

namespace App\Models\core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class esn extends Model
{
    use HasFactory;

    protected $fillable = ['stock_id', 'esn', 'sku','status','batch','user_id'];
}
