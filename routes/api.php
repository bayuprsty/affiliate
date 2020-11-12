<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', 'Api\ApiController@login');

Route::middleware('auth:api', function() {
    Route::post('/setLeadData', 'Api\ApiController@setDataLead');
    Route::post('/setTransactionData', 'Api\ApiController@setDataTransaction');
});
