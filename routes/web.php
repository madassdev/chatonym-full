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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/u/{user}', function(App\Models\User $user){

    return view('test.message',['user'=>$user]);
});

Route::get('/', function(App\Models\User $user){

    return view('test.feeds');
});

Route::get('/interface', 'HomeController@interface');
Route::get('/u/{user}', 'HomeController@writeMessage');
Route::get('/u/{user}/send', 'HomeController@sendMessage');
Route::post('/u/{user}', 'HomeController@sendMessage')->name('users.messages.send');
Route::post('/users/token', 'HomeController@saveToken')->name('users.tokens.create');
