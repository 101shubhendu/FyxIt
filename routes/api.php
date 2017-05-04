<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'cors','prefix' => '/'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');
    Route::resource('categories', 'CategoryApiController');
    Route::resource('tags', 'TagApiController',['except' => ['edit']]);
    Route::resource('posts','PostApiController',['except' => ['edit','create']]);
    Route::get('post/like/{id}','LikeApiController@likePost');
    Route::get('comment/like/users/{id}','LikeApiController@showComment');
    Route::get('post/like/users/{id}','LikeApiController@showPost');
    Route::get('comment/like/{id}', 'LikeApiController@likeComment');
    Route::post('comments/{post_id}', 'CommentsApiController@store');
    Route::get('comments/{post_id}', 'CommentsApiController@show');
    Route::put('comments/{id}', 'CommentsApiController@update');
    Route::delete('comments/{id}','CommentsApiController@destroy');
    Route::get('profile/',['as' =>'user.profile','uses' => 'ProfileApiController@index']);
    Route::put('profile/{user_id}',['as' =>'user.update','uses' => 'ProfileApiController@update']);
    Route::get('profile/{user_id}',['as' =>'user.profile','uses' => 'ProfileApiController@show']);
    Route::post('map',['as' =>'locations','uses' => 'HeatMapApiController@index']);
    Route::post('map/posts',['as' =>'locations','uses' => 'HeatMapApiController@posts']);


});
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('jwt.auth');
