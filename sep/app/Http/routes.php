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

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');

Route::get('new-ticket', 'users\newticketController@index');
Route::post('new-ticket', 'users\newticketController@inputs');

Route::get('admin/usermanage', 'admin\RegisterdUserManagment@index');
Route::post('admin/usermanage', 'admin\RegisterdUserManagment@inputs');

Route::get('profile', 'users\UsrProfileController@index');
Route::post('profile', 'users\UsrProfileController@inputs');

Route::get('doctors', 'DoctorController@index');
Route::get('doctors/edit/{id}', 'DoctorController@edit');
Route::post('doctors/edit/{id}', 'DoctorController@update');
Route::get('newdoctor', 'DoctorController@newdoctor');
Route::post('newdoctor', 'DoctorController@insertNew');
Route::get('doctors/{id}', 'DoctorController@show');
Route::post('doctors', 'DoctorController@sortfilter');
Route::get('pending', 'DoctorController@pendingdoctor');


Route::get('login', 'loginController@index');
Route::post('login','loginController@inputs');
Route::get('signout','loginController@signout');

Route::get('rate','rateController@index');




Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
