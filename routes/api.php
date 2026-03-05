<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TownsController;
use App\Http\Controllers\Webhook\StripeController;

Route::group(['prefix' => '/v1'], function(){
    Route::resource('cities', TownsController::class);
});


Route::post('stripe/webhook', [StripeController::class, 'handleWebhook']);

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

});
