<?php

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

//M1 Aufgabe 5
Route::get('/testdata', [
    \App\Http\Controllers\AbTestDataController::class, 'testMethod']);

//M1 Aufgabe 6
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');

//M1 Aufgabe 10
//Route::get('/articles', [\App\Http\Controllers\AbaloController::class, 'search']);

Route::get('/newArticle', function (){
    return view('newArticle');
});

Route::post('/newArticle', [\App\Http\Controllers\AbaloController::class, 'newArticle'])->name('newArticle');

Route::get('/new-article-api', function () {
    return view('newArticleApi');
});

// M4
Route::get('/articles', function () {
    return view('searchVue');
});

Route::get('/newsite', function () {
    return view('newsite');
});
