<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\TownsController;
use App\Http\Controllers\Webhook\StripeController;

Route::group(['prefix' => '/v1'], function(){
    Route::resource('cities', TownsController::class);
    Route::get('google/maps', [ApiController::class, 'googleMaps']);
    Route::get('google/places', [ApiController::class, 'googlePlaces']);
});


Route::post('stripe/webhook', [StripeController::class, 'handleWebhook']);


Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

});
