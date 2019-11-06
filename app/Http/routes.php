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

// Pages
Route::get('user/{id}', array('as' => 'home', 'uses' => 'PostsController@get_posts_by_user_newest'));

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');                                            // login page
Route::post('auth/login', 'Auth\AuthController@postLogin');                                          // store session
Route::get('auth/logout', 'Auth\AuthController@getLogout');                                          // delete session
//
// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');                                      // register page
Route::post('auth/register', 'Auth\AuthController@postRegister');                                    // store register user

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
//
// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Post routes begins here
Route::get('/', array('as' => 'frontpage', 'uses' => 'PostsController@get_posts_trending'));         // frontpage
Route::get('{id}', array('as' => 'posts.show', 'uses' => 'PostsController@show'));                   // show post
Route::get('transfer/upload', array('as' => 'posts.create', 'uses' => 'PostsController@create'));         // create post
Route::post('transfer/upload', array('as' => 'posts.store', 'uses' => 'PostsController@store'));                                                // store post

Route::post('post/{id}/report', array('as' => 'posts.report', 'uses' => 'PostsController@post_report'));         // report post
Route::delete('post/{id}/delete', array('as' => 'posts.destroy', 'uses' => 'PostsController@destroy'));


 // delete post
Route::get('lookingFor/upload', array('as' => 'posts.search', 'uses' => 'PostsController@get_posts_search'));

// Post rating routes begins here
Route::post('{id}/vote', array('as' => 'postsRatings.store', 'uses' => 'PostsController@rate_posts_by_users'));

// Comment routes begins here
Route::post('{id}', array('as' => 'comments.store', 'uses' => 'CommentsController@store'));
Route::delete('{id}/comment/delete', array('as' => 'comments.destroy', 'uses' => 'CommentsController@destroy'));

Route::post('comment/{id}/report', array('as' => 'comments.report', 'uses' => 'CommentsController@comment_report'));

// Admin routes here
Route::get('admin/panel', array('as' => 'admin.index', 'uses' => 'AdminsController@index'));
Route::delete('admin/panel/remove/postReports/{id}', array('as' => 'DeletePostReports', 'uses' => 'AdminsController@post_reports_destroy')); // remove reports on post
Route::delete('admin/panel/remove/commentReports/{id}', array('as' => 'DeleteCommentReports', 'uses' => 'AdminsController@comment_reports_destroy')); // remove reports on comments

