<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Administration routes.
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['customizedAuth', 'admin']], function (){
    Route::get('/', 'AdminController@index');
});

//Partner routes.
Route::group(['namespace' => 'Partner', 'prefix' => 'partner', 'middleware' => ['customizedAuth', 'partner']], function (){
    Route::get('/', 'PartnerController@index');
});

//Home routes.
Route::group(['namespace' => 'Home', 'prefix' => 'home', 'middleware' => ['customizedAuth']], function (){
    Route::get('/', 'HomeController@index');
});

