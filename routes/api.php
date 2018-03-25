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
Route::group(['middleware' => ['api']], function () {
    Route::post('auth/login', 'UserController@login');
    Route::post('auth/register', 'UserController@register');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('country', 'CountryController@index');
        
        Route::post('province', 'ProvinceController@index');
        Route::post('province/bycountry', 'ProvinceController@getByCountry');
        
        Route::post('city', 'CityController@index');
        Route::post('city/by', 'CityController@getBy');

        Route::post('locker', 'LockerController@index');
        Route::post('locker/bycity', 'LockerController@getByCity');
        Route::post('locker/byposition', 'LockerController@getByPosition');
        
        Route::post('buildingtype', 'BuildingController@index');

        Route::post('order/save', 'OrderController@save');
        Route::post('order/detail', 'OrderController@detail');
        Route::post('order/history', 'OrderController@history');

    });
});