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

require 'Routes/astRoutes.php';


Route::get('/', function () {
    return view('welcome');
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('home', ['middleware'=>'adLogin', 'uses'=>'ast\astMenuController@index']);

Route::get('noAccess', ['as'=>'noAccess', 'uses'=>'ast\astMenuController@noAccess']);
