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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'cors', 'prefix' => '/v1'], function () {
    Route::post('/login', 'UserController@authenticate');
    Route::post('/register', 'UserController@register');
    Route::get('/logout/{api_token}', 'UserController@logout');
});

Route::get('/films', 'FilmController@index');

Route::get('/films/{id}', 'FilmController@show');

Route::post('/films/save', 'FilmController@store');
Route::post('/films/update', 'FilmController@update');


Route::get('/articles', 'ArticleController@index');

Route::get('/articles/{id}', 'ArticleController@show');

Route::post('/articles/save', 'ArticleController@store');

Route::post('/articles/update', 'ArticleController@update');

Route::get('/articles/delete/{id}/{api_token}', 'ArticleController@delete');