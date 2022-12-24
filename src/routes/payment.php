<?php

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PostbackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Payment Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'transaction'], function () {
    Route::post('{customer}', [PaymentController::class, 'makeTransaction']);
});

Route::group(['prefix' => 'postback'], function(){
    Route::post('', [PostbackController::class, 'postback']);
//    ->middleware('postback');
});
