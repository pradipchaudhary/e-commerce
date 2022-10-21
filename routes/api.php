<?php

use App\Http\Controllers\api\ApiHelperController;
use Illuminate\Support\Facades\Route;


Route::get('grade-scale', [ApiHelperController::class, 'getGradeScaleDetailById'])->name('api.getGradeScaleDetailById');
Route::get('stock', [ApiHelperController::class, 'stockReport'])->name('api.stock.index');
Route::get('stock-log', [ApiHelperController::class, 'stockLogReport'])->name('api.stock_log.stockLogReport');
Route::get('stock-setting', [ApiHelperController::class, 'loadStockSetting'])->name('api.loadStockSetting');
Route::get('get-state-by-country', [ApiHelperController::class, 'getStateByCountry'])->name('api.getStateByCountry');
Route::get('get-city-by-state', [ApiHelperController::class, 'getCityByState'])->name('api.getCityByState');
Route::get('check-email', [ApiHelperController::class, 'checkEmail'])->name('api.checkEmail');
Route::get('genearte-sku', [ApiHelperController::class, 'getUniqueSku'])->name('api.getUniqueSku');
Route::get('check-sku', [ApiHelperController::class, 'checkSku'])->name('api.checkSku');
Route::get('stock-by-id', [ApiHelperController::class, 'getStockById'])->name('api.getStockById');
Route::get('stock-cart-id', [ApiHelperController::class, 'getCartById'])->name('api.getCartById');
Route::get('data-by-offer-id', [ApiHelperController::class, 'getDataByOfferId'])->name('api.getDataByOfferId');
Route::get('offer-setting-data', [ApiHelperController::class, 'getOfferSettingData'])->name('api.getOfferSettingData');
Route::get('check-esn', [ApiHelperController::class, 'checkEsn'])->name('api.checkEsn');
Route::get('get-user-detail', [ApiHelperController::class, 'getUserDetail'])->name('api.getUserDetail');
