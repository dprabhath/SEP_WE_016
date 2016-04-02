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

Route::get('new-ticket', 'users\NewTicketController@index');
Route::post('new-ticket', 'users\NewTicketController@inputs');

Route::get('view-ticket', 'users\TicketController@index');
Route::post('view-ticket', 'users\TicketController@inputs');


Route::get('admin/usermanage', 'admin\RegisterdUserManagment@index');
Route::post('admin/usermanage', 'admin\RegisterdUserManagment@inputs');

Route::get('admin/view-ticket', 'admin\TicketControllerAdmin@index');
Route::post('admin/view-ticket', 'admin\TicketControllerAdmin@inputs');

Route::get('profile', 'users\UserProfileController@index');
Route::get('profile/schedule', 'DoctorController@createSchedule');
Route::post('profile/schedule', 'DoctorController@updateSchedule');
Route::post('profile', 'users\UserProfileController@inputs');


Route::get('doctors', 'DoctorController@index');
Route::get('doctors/edit/{id}', 'DoctorController@edit');
Route::post('doctors/edit/{id}', 'DoctorController@update');
Route::get('doctors/review/{id}', 'DoctorController@doctorReview');
Route::post('doctors/review/{id}', 'DoctorController@updateDoctorReview');
Route::get('newdoctor', 'DoctorController@newdoctor');
Route::post('newdoctor', 'DoctorController@insertNew');
Route::get('doctors/{id}', 'DoctorController@show');
Route::post('doctors', 'DoctorController@sortfilter');
Route::get('admin/pending/{id}', 'DoctorController@showPending');
Route::get('admin/pending', 'DoctorController@pendingdoctor');
Route::get('admin/newphysician', 'DoctorController@newFormalPhysician');
Route::post('admin/newphysician', 'DoctorController@insertNewFormal');
Route::get('admin/approvedlist', 'DoctorController@approvedList');
Route::get('admin/doctorcredentials', 'DoctorController@doctorCredentials');
Route::post('admin/doctorcredentials', 'DoctorController@createDoctorCredentials');
Route::post('pending', 'DoctorController@pendingAction');

Route::get('treatments', 'TreatmentController@index');
Route::get('admin/pendingtreatments/{id}', 'TreatmentController@showPendingTreatment');
Route::get('admin/pendingtreatments', 'TreatmentController@pendingTreatment');
Route::post('pendingtreatments', 'TreatmentController@pendingAction');
Route::get('treatments/new', 'TreatmentController@newTreatment');
Route::get('treatments/{id}', 'TreatmentController@show');
Route::get('treatments/edit/{id}', 'TreatmentController@edit');
Route::post('treatments/new', 'TreatmentController@insertNew');


Route::get('verify', 'users\VerifyController@index');
Route::post('verify','users\VerifyController@inputs');
Route::get('register', 'RegistrationController@index');
Route::post('register','RegistrationController@inputs');
Route::get('login', 'LoginController@index');
Route::post('login','LoginController@inputs');
Route::get('signout','LoginController@signout');
Route::get('googleauth','LoginController@gauth');

Route::get('rate','rateController@index');

Route::get('user/{id}', 'users\profileviewer@show');
Route::get('setappointment-user/{id}', 'users\appointmentUser@show');



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
