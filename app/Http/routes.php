<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Admin Index Route
Route::get('admin', ['as' => 'admin', 'uses' => 'AdminController@index']);

// API routes
Route::any('api/widget', 'ApiController@widgetData');

// Authentication routes…
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

//forgot password routes…
Route::controllers([
    'password' => 'Auth\PasswordController',
]);

//Pages routes...
Route::get('/', 'PagesController@index');
Route::get('terms-of-service', 'PagesController@terms');
Route::get('privacy', 'PagesController@privacy');

// Registration routes…
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Socialite routes
Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');

//Test Controller
Route::get('test', ['middleware' => ['auth', 'admin'], 'uses' => 'TestController@index']);

// widget routes
Route::get('widget/create', ['as' => 'widget.create', 'uses' => 'WidgetController@create']);
Route::get( 'widget/{id}-{slug?}', ['as' => 'widget.show', 'uses' => 'WidgetController@show']);
Route::resource('widget', 'WidgetController', ['except' => ['show', 'create']]);