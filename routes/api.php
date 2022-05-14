<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('articles')->group(function () {
    Route::get('/', '\App\Http\Controllers\ArticleController@allAticles');
    Route::get('/{id}', '\App\Http\Controllers\ArticleController@singleArticle');
    Route::get('/{id}/comment', '\App\Http\Controllers\ArticleController@ArticleComments');
    Route::get('/{id}/views', '\App\Http\Controllers\ArticleController@ArticleViews');
    Route::get('/{id}/like', '\App\Http\Controllers\ArticleController@ArticleLikes');
    Route::post('/', '\App\Http\Controllers\ArticleController@store');
    Route::post('/{id}/comment', '\App\Http\Controllers\ArticleController@comment');
    Route::post('/{id}/views', '\App\Http\Controllers\ArticleController@view');
    Route::post('/{id}/like', '\App\Http\Controllers\ArticleController@like');
});
