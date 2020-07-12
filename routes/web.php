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

Route::get('/home', 'QuestionController@index')->name('question.index');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile/{user}/edit', 'ProfileController@edit')->name('profile.edit');
    Route::patch('/profile/{user}', 'ProfileController@update')->name('profile.update');

    Route::get('/question/create', 'QuestionController@create')->name('question.create');
    Route::post('/question', 'QuestionController@store')->name('question.store');
    Route::get('/question/{id}/edit', 'QuestionController@edit')->name('question.edit');
    Route::patch('/question/{id}', 'QuestionController@update')->name('question.update');
});

Route::get('/profile/{user}', 'ProfileController@index')->name('profile.index');

Route::get('/question/{id}', 'QuestionController@show')->name('question.show');
// Menggunakan href utk delete question
Route::get('/question/del/{id}', 'QuestionController@destroy')->name('question.destroy');
// Menggunakan form utk delete question
// Route::delete('/question/{id}', 'QuestionController@destroy')->name('question.destroy');

Route::post('/answer/{id}', 'AnswerController@store')->name('answer.store');
Route::get('/answer/{id}', 'AnswerController@edit')->name('answer.edit');
Route::patch('/answer/{id}', 'AnswerController@update')->name('answer.update');
// Menggunakan href untuk delete answer
Route::get('/answer/del/{id}', 'AnswerController@destroy')->name('answer.destroy');
// Menggunakan form utk delete answer
// Route::delete('/answer/{id}', 'AnswerController@destroy')->name('answer.destroy');

Route::get('/vote/up/{id}', 'VoteController@upvote')->name('vote.upvote');
Route::get('/vote/down/{id}', 'VoteController@downvote')->name('vote.downvote');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function() {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});