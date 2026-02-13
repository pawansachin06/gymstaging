<?php

Route::group(['prefix' => '/v1'], function(){
    Route::resource('cities', TownsController::class);
});



Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

});
