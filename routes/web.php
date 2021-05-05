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

// Web authenticated routes
Route::middleware('auth')->group(function() {
    Route::get('/users/{username}', function ($username) {
        return view('user_profile', ['username' => $username]);
    });

    Route::get('/categories/{id}', function ($id) {
        return view('category', ['id' => $id]);
    });

    Route::get('/hobby/{id}', function ($id) {
        return view('comments', ['id' => $id]);
    });

    Route::get('users/{id}/followers', function($id) {
        return view('followers', ['id' => $id]);
    });

    Route::get('users/{id}/following', function($id) {
        return view('following', ['id' => $id]);
    });

    Route::get('users/me/edit', function() {
        return view('edit_profile');
    });

    Route::middleware('admin')->group(function() {
        Route::get('admin/users', function() {
            return view('admin/users_list');
        });
        Route::get('admin/users/{id}/edit', function($id) {
            return view('admin/edit_user', ['id' => $id]);
        });

    });
});

// API routes
Route::middleware('check.auth')->group(function() {
    Route::get('/api/users/{username}', 'Api\UsersApiController@getInfoByUsername');
    Route::get('/api/users/id/{id}', 'Api\UsersApiController@getById');
    Route::put('/api/users/{id}/edit', 'Api\UsersApiController@update');
    Route::post('/api/users/{id}/follow', 'Api\UsersApiController@follow');
    Route::delete('/api/users/{id}/unfollow', 'Api\UsersApiController@unfollow');
    Route::get('/api/users/{id}/followers', 'Api\UsersApiController@getFollowers');
    Route::get('/api/users/{id}/following', 'Api\UsersApiController@getFollowing');
    Route::post('/api/hobbies/add', 'Api\HobbiesApiController@add');
    Route::get('/api/hobbies/latest', 'Api\HobbiesApiController@showHobbies');
    Route::get('/api/hobbies/{id}/comments', 'Api\HobbiesApiController@getComments');
    Route::post('/api/hobbies/{id}/comment', 'Api\UsersApiController@addComment');
    Route::get('/api/categories', 'Api\CategoryApiController@getAll');
    Route::get('/api/categories/{id}/hobbies', 'Api\CategoryApiController@getHobbiesByCategory');

    Route::middleware('admin')->group(function() {
        Route::get('/api/admin/users', 'Api\UsersApiController@getAllForAdmin');
        Route::get('/api/admin/users/{id}', 'Api\UsersApiController@getById');
        Route::put('/api/admin/users/{id}/edit', 'Api\UsersApiController@update');
        Route::delete('/api/admin/users/{id}/delete', 'Api\UsersApiController@delete');
    });
});
