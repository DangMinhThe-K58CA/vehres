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

Route::get('/', 'Home\HomeController@welcome');


Auth::routes();

//Administration routes.
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['customizedAuth', 'admin']], function (){
    Route::get('/', 'AdminController@index')->name('admin');

    //Routes for managing users.
    Route::resource('managingUsers', 'UserController');

    //Route manage Garages
    Route::resource('garages', 'GarageController', ['only' => ['index', 'update', 'destroy', 'show']]);
});

//Partner routes.
Route::group(['namespace' => 'Partner', 'prefix' => 'partner', 'middleware' => ['customizedAuth', 'partner']], function (){
    Route::get('/', 'PartnerController@index')->name('partner');

    //Route for managing garages.
    Route::post('updateLocation', 'GarageController@updateLocation');
    Route::get('garageMaps', 'GarageController@garageMaps');
    Route::resource('garages', 'GarageController');

    //Route for managing articles.
    Route::resource('articles', 'ArticleController');
});

//Home routes.
Route::group(['namespace' => 'Home', 'prefix' => 'home', 'middleware' => ['customizedAuth']], function (){

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/myWorld', 'HomeController@myWorld');
    Route::get('/getGaragesListView', 'HomeController@getGaragesListView');

    //Routes for home user.
    Route::resource('users', 'UserController', ['except' => [
        'store', 'create', 'destroy', 'show'
    ]]);

    //Route for home page interact with maps.
    Route::group(['prefix' => 'garage'], function () {
        Route::get('/getInitParameters', 'GarageController@getInitParameters');
        Route::get('/getGarages', 'GarageController@getGarages');
        Route::get('/show', 'GarageController@show');
        Route::get('/view', 'GarageController@getSpecificGarage');
        Route::post('/rate', 'GarageController@rate');
    });

    //Route for home article.
    Route::group(['prefix' => 'article'], function () {
        Route::get('/getArticles', 'ArticleController@getArticle');
        Route::get('/view', 'ArticleController@getSpecificArticle');
    });

    //Route for home page comment.
    Route::resource('/comments', 'CommentController');

    //Route for home page bookmark.
    Route::get('/bookmarks/search', 'BookmarkController@search');
    Route::resource('/bookmarks', 'BookmarkController');

    //Route for home page visit.
    Route::get('/visits/search', 'VisitController@search');
    Route::resource('/visits', 'VisitController');
});

//Account activation route
Route::get('/accountActive', 'Auth\VerifyAccountController@activateAccount');

//Administration unit route
Route::get('/getChildrenAdministrationUnit', 'AdministrationUnitController@getChildren');
