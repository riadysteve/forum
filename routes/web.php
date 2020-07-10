<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/home', 'QuestionController@index')->name('question.index');

Route::get('/profile/{user}', 'ProfileController@index')->name('profile.index');
Route::get('/profile/{user}/edit', 'ProfileController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfileController@update')->name('profile.update');

Route::get('/question/create', 'QuestionController@create')->name('question.create');
Route::post('/question', 'QuestionController@store')->name('question.store');
Route::get('/question/{id}', 'QuestionController@show')->name('question.show');
Route::get('/question/{id}/edit', 'QuestionController@edit')->name('question.edit');
Route::patch('/question/{id}', 'QuestionController@update')->name('question.update');
Route::delete('/question/{id}', 'QuestionController@destroy')->name('question.destroy');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function() {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});