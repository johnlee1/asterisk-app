<?php
/**
 * User Authentication Management via Active Directory login
 */
Route::get('login', array('as'=>'login','uses'=>'LoginController@index'));
Route::post('login/update', array( 'as'=>'update_login', 'uses'=>'LoginController@update'));
Route::get('logoff', array('as'=>'logoff', 'uses'=>'LoginController@logoff'));