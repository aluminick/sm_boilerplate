<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::auth();

// Route::get('/home', 'HomeController@index');

// Route::get('/{user}', function () {
//     return 'User page';
// });
//
// Route::get('/{user}/{post}', function () {
//     return 'User Post page';
// });

//Post Routes
Route::get('/posts', 'PostController@index');
Route::post('/post', 'PostController@store');
Route::put('/post/{post}', 'PostController@update');
Route::delete('/post/{post}', 'PostController@destroy');

//Comment Routes
Route::get('/comments', 'CommentController@index');
Route::post('/comment', 'CommentController@store');
Route::put('/comment/{comment}', 'CommentController@update');
Route::delete('/comment/{comment}', 'CommentController@destroy');

Route::get('/api/comments/{comment}', 'CommentController@findOne');
Route::get('/api/comments/post/{post}', 'CommentController@postComments');
Route::get('/api/comments/findfive/{post}', 'CommentController@findFive');
Route::get('/api/comments/nextfive/{post}', 'CommentController@nextFive');

//Post Like Routes
//Route::get('/likes/post/{post}', 'PostLikeController@index');
Route::post('/likes/post/{post}', 'PostLikeController@store');
Route::put('/likes/post/{post}', 'PostLikeController@update');

//Comment Like Routes
Route::post('/likes/comment/{comment}', 'CommentLikeController@store');
Route::put('/likes/comment/{comment}', 'CommentLikeController@update');
