<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    if(!Auth::check())
    {   $message = '';
        return view('auth.login')->with('message',$message);
    }
    return redirect()->action('FeedController@getIndex');
});
Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Auth\RegisterController@confirm'
]);
Route::group(['middleware' => ['web']], function () {
    Route::resource('categories', 'CategoryController');
    Route::resource('tags', 'TagController', ['except' => ['create']]);
    Route::resource('posts', 'PostController');
    Route::post('comments/{post_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
    Route::get('comments/{id}/edit', ['uses' => 'CommentsController@edit', 'as' => 'comments.edit']);
    Route::put('comments/{id}', ['uses' => 'CommentsController@update', 'as' => 'comments.update']);
    Route::delete('comments/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy']);
    Route::get('comments/{id}/delete', ['uses' => 'CommentsController@delete', 'as' => 'comments.delete']);
    Route::get('feed/{slug}', ['as' => 'feed.single', 'uses' => 'FeedController@getSingle'])->where('slug', '[\w\d\-\_]+');
    Route::get('feed', ['uses' => 'FeedController@getIndex', 'as' => 'feed.index']);
    Route::get('post/like/{id}', ['as' => 'post.like', 'uses' => 'LikeController@likePost']);
    Route::get('comment/like/{id}', ['as' => 'comment.like', 'uses' => 'LikeController@likeComment']);
    Route::get('profile/{user_id}',['as' =>'user.show','uses' => 'ProfileController@show']);
    Route::get('profile/',['as' =>'user.profile','uses' => 'ProfileController@index']);
    Route::put('profile/{user_id}',['as' =>'user.update','uses' => 'ProfileController@update']);
    Route::get('profile/edit/{user_id}',['as' =>'user.edit','uses' => 'ProfileController@edit']);
    Route::get('map',['as' =>'map.heat','uses' => 'HeatMapController@index']);
    Route::get('map/posts',['as' =>'map.nearby','uses' => 'HeatMapController@posts']);
    Route::post('map/',['uses' => 'HeatMapController@index']);
    Route::post('map/posts',['uses' => 'HeatMapController@posts']);

});

Auth::routes();
Route::get('/home', 'HomeController@index');



