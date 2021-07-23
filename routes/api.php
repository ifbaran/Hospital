<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'api'], function(){
    Route::get('/working-hours/{date?}','WorkingHoursController@getWorkingHours');
    Route::post('/appointment', 'AppointmentController@storeAppointment');

    Route::group(['namespace'=>'admin', 'prefix'=> 'admin'],function(){
        Route::post('/process','AdminAPIController@process');
        Route::get('/all', 'AdminAPIController@all');
        Route::get('appointment-list','AdminAPIController@getAppointmentList');
        Route::get('appointment-today-list','AdminAPIController@getTodayAppointmentList');
        Route::get('appointment-last-list','AdminAPIController@getLastAppointmentList');
        Route::get('appointment-waiting-list','AdminAPIController@getWaitingAppointmentList');
        Route::get('appointment-cancel-list','AdminAPIController@getCancelAppointmentList');
    });

});
