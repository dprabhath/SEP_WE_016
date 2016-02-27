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

Route::get('new-ticket', 'users\newTicketController@index');
Route::post('new-ticket', 'users\newTicketController@inputs');

Route::get('view-ticket', 'users\ticketController@index');
Route::post('view-ticket', 'users\ticketController@inputs');


Route::get('admin/usermanage', 'admin\registerdUserManagment@index');
Route::post('admin/usermanage', 'admin\registerdUserManagment@inputs');

Route::get('admin/view-ticket', 'admin\ticketControllerAdmin@index');
Route::post('admin/view-ticket', 'admin\ticketControllerAdmin@inputs');

Route::get('profile', 'users\userProfileController@index');
Route::post('profile', 'users\userProfileController@inputs');

Route::get('doctors', 'DoctorController@index');
Route::get('doctors/edit/{id}', 'DoctorController@edit');
Route::post('doctors/edit/{id}', 'DoctorController@update');
Route::get('newdoctor', 'DoctorController@newdoctor');
Route::post('newdoctor', 'DoctorController@insertNew');
Route::get('doctors/{id}', 'DoctorController@show');
Route::post('doctors', 'DoctorController@sortfilter');
Route::get('pending', 'DoctorController@pendingdoctor');

Route::get('register', 'registrationController@index');
Route::post('register','registrationController@inputs');
Route::get('login', 'loginController@index');
Route::post('login','loginController@inputs');
Route::get('signout','loginController@signout');

Route::get('rate','rateController@index');




Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
