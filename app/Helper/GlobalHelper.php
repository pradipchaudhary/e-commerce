<?php

use App\Models\core\order_log;
use App\Models\stock;
use App\Models\User;
use Illuminate\Support\Str;

function getRandomNumber()
{
    $randomInt = random_int(999999, 10000000);
    if (stock::query()->where('product_no', $randomInt)->first() != null) {
        getRandomNumber();
    } else {
        return $randomInt;
    }
}

function getUniqueSku()
{
    $randomInt = random_int(9999999, 100000000);
    if (stock::query()->where('sku', $randomInt)->first() != null) {
        getUniqueSku();
    } else {
        return $randomInt;
    }
}

function getUniqueTokenForOrderLog()
{
    $token = config('CONSTANT.ORDER_TOKEN_PREFIX') . random_int(1111, 100000);
    if (order_log::query()->where('token', $token)->count()) {
        getUniqueTokenForOrderLog();
    } else {
        return $token;
    }
}

function getUniqueTrackId()
{
    $token = Str::random(15);
    if (order_log::query()->where('track_id', $token)->count()) {
        getUniqueTrackId();
    } else {
        return $token;
    }
}

function getUniqueOTP()
{
    $token = random_int(10000, 99999);
    if (User::query()->where('remember_token', $token)->count()) {
        getUniqueOTP();
    } else {
        return $token;
    }
}
