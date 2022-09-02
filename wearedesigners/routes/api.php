<?php
//Tharindu Prabash - All Rights Reserved - 2022
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users API
    Route::apiResource('users', 'UsersApiController');
});
