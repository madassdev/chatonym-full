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

// require __DIR__.'/auth.php';

Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::post('/login','Auth\LoginController@login')->name('login');
Route::get('/logout','Auth\LoginController@logout')->name('logout');

Route::get('/u/{user}/xxx', function(App\Models\User $user){

    return view('test.message',['user'=>$user]);
});

// Route::get('/', function(App\Models\User $user){

//     return view('test.feeds');
// });

Route::get('/', 'HomeController@interface')->name('home');
Route::get('/interface', 'HomeController@interface');
Route::get('/u/{user}', 'HomeController@writeMessage');
Route::get('/u/{user}/send', 'HomeController@sendMessage');
Route::post('/u/{user}', 'HomeController@sendPm')->name('users.messages.send');
Route::post('/users/token', 'HomeController@saveToken')->name('users.tokens.create');

Route::prefix('account')->middleware('auth')->group(function(){
    Route::get('/', 'UserController@showProfile')->name('user.profile.show');
    Route::get('/messages', 'UserController@showMessages')->name('user.messages.show');
    Route::post('/password', 'UserController@updatePassword')->name('user.password.update');
    Route::get('/threads', 'UserController@showThreads')->name('user.threads.show');
});




Route::prefix('feeds')->group(function(){
    Route::get('/', 'FeedController@index')->name('feed.index');
    Route::post('/', 'FeedController@create')->name('feed.create');
    Route::get('/fetch', 'FeedController@fetchFeeds')->name('feed.fetch');
    Route::get('/{feed}', 'FeedController@showFeed')->name('feed.show');
    Route::post('/{feed}', 'FeedController@replyFeed')->name('feed.reply');
    // Route::get('/threads', 'UserController@showThreads')->name('user.threads.show');
});


Route::prefix('threads')->middleware('auth')->group(function(){
    Route::get('/', 'ThreadController@index')->name('thread.index');
    Route::post('/', 'ThreadController@create')->name('thread.create');
    // Route::get('/threads', 'UserController@showThreads')->name('user.threads.show');
});

