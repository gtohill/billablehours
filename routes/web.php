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

Route::get('tasks/createtask/{id}', 'ClientTasksController@createtask');
Route::get('/', 'IndexController@home' );
Route::get('about', 'IndexController@about' );
Route::resource('accounts', 'ClientController' ); // CRUD for client account
Route::resource('tasks', 'ClientTasksController' ); // CRUD for tasks
Route::resource( 'opentask', 'OpenTaskController' ); //   
Route::resource( 'completed', 'CompletedTasksController' );
Route::resource('autosave', 'AutoSaveController');

// actions to the invoice controller
Route::post('invoice', 'InvoiceController@invoice');
Route::post('invoice/update', 'InvoiceController@update');
Route::get('invoice/{id}', 'InvoiceController@show');
Route::get('invoice/{id}/edit', 'InvoiceController@edit');

// custom resource
Route::post('edittask', 'ClientTasksController@edittask');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
