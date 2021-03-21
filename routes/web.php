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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';

Route::post('/mock', function () {
    return true;
});
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/u/{user}/xxx', function (App\Models\User $user) {

    return view('test.message', ['user' => $user]);
});

// Route::get('/', function(App\Models\User $user){

//     return view('test.feeds');
// });
Route::domain('{vue}.chatonym.dv')->group(function () {
    Route::get('/', function () {
        return view('vue.landing');
    });
});




Route::get('/', 'HomeController@interface')->name('home');
Route::get('/vuefeeds', 'HomeController@vuefeeds')->name('vuefeeds');
Route::get('/interface', 'HomeController@interface');
Route::get('/u/{user}', 'HomeController@writeMessage');
Route::get('/peep/{user}', 'HomeController@peepMessage');
Route::get('/u/{user}/send', 'HomeController@sendMessage');
Route::post('/u/{user}', 'HomeController@sendPm')->name('users.messages.send');
Route::post('/users/token', 'HomeController@saveToken')->name('users.tokens.create');

Route::prefix('account')->middleware('auth')->group(function () {
    Route::get('/', 'UserController@showProfile')->name('user.profile.show');
    Route::get('/messages', 'UserController@showMessages')->name('user.messages.show');
    Route::post('/password', 'UserController@updatePassword')->name('user.password.update');
    Route::get('/threads', 'UserController@showThreads')->name('user.threads.show');
});




Route::prefix('feeds')->group(function () {
    Route::get('/', 'FeedController@index')->name('feed.index');
    Route::post('/', 'FeedController@create')->name('feed.create')->middleware('auth');
    Route::get('/fetch', 'FeedController@fetchFeeds')->name('feed.fetch');
    Route::get('/{feed}', 'FeedController@showFeed')->name('feed.show');
    Route::post('/{feed}', 'FeedController@replyFeed')->name('feed.reply')->middleware('auth');
    Route::post('/{feed}/update_image', 'FeedController@updateFeedImage')->name('feed.image.update')->middleware('auth');
    Route::post('/{feed}/react', 'FeedController@reactToFeed')->name('feed.reply')->middleware('auth');
    // Route::get('/threads', 'UserController@showThreads')->name('user.threads.show');
});


Route::prefix('thread')->middleware('auth')->group(function () {
    Route::get('/', 'ThreadController@index')->name('thread.index');
    Route::get('/{thread}', 'ThreadController@showThread')->name('thread.show');
    Route::post('/{thread}', 'ThreadController@sendThreadMessage')->name('thread.show');
    Route::get('/{thread}/fetch', 'ThreadController@fetchMessages')->name('thread.fetch');
    Route::post('/', 'ThreadController@create')->name('thread.create');
    // Route::get('/threads', 'UserController@showThreads')->name('user.threads.show');
});
