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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('usermanage', 'RegisterdUserManagment@index');

Route::get('profile', 'UsrProfileController@index');
Route::post('profile', 'UsrProfileController@inputs');

Route::get('doctors', 'DoctorController@index');
Route::get('doctors/edit/{id}', 'DoctorController@edit');
Route::post('doctors/edit/{id}', 'DoctorController@update');
Route::get('doctors/{id}', 'DoctorController@show');
Route::post('doctors', 'DoctorController@sortfilter');


Route::get('login', 'loginController@index');
Route::post('login','loginController@inputs');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
