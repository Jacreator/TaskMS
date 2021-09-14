<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/workspace', 'DashboardController@index')->name('workspace');
Route::post('/project', 'ProjectController@store')->name('create-project');
Route::post('/getTasks', 'TaskController@index')->name('getTask');
Route::post('/tasks', 'TaskController@store')->name('create-task');
Route::get('/tasks/{task}', 'TaskController@edit')->name('task-edit');
Route::post('/task/{task}', 'TaskController@update')->name('task-update');
Route::get('/task/task', 'TaskController@destroy')->name('task-destroy');
Route::get('/task/reorder', 'TaskController@reorder')->name('task-reorder');
Route::get('/taskfile/{taskFile}', 'TaskController@deleteFile')->name('task-deletefile');