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
    return view('dashboard');
})->middleware('auth');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
// Route::get('/system-management/{option}', 'SystemMgmtController@index');
Route::get('/profile', 'ProfileController@index');

Route::post('user-management/search', 'UserManagementController@search')->name('user-management.search');
Route::resource('user-management', 'UserManagementController');




Route::get('avatars/{name}', 'EtudiantController@load');

Route::resource('system-management/roles', 'RolesController');
Route::post('system-management/roles/search', 'RolesController@search')->name('roles.search');

Route::resource('system-management/niveau', 'NiveauController');
Route::post('system-management/niveau/search', 'NiveauController@search')->name('niveau.search');

//etudiants

Route::resource('system-management/etudiant', 'EtudiantController');

Route::get('system-management/etudiant/edit/{id}', 'EtudiantController@edit')->name('etudiantEdit');

Route::post('system-management/etudiant/search', 'EtudiantController@search')->name('etudiant.search');

Route::post('system-management/etudiant/update', 'EtudiantController@update')->name('etudiant-management.update');

Route::get('system-management/etudiant/show/{id}', 'EtudiantController@show')->name('etudiantShow');


