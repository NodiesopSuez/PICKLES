<?php

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \App\Http\Controllers\FavoritesController;
use \App\Http\Controllers\Auth\RegisterController;

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

Route::middleware('auth:api') -> get('/user', function (Request $request) {
    return $request -> user();
});

//Usersテーブルの全レコード取得
Route::get('/get_users_data', 'GetUserController@get');

//SignUpからユーザー登録
Route::post('/register_user', 'Auth\RegisterController@store');

//ログイン
Route::post('/login', '');

//favoritesテーブルの全レコード取得(デバック用)
Route::get('/get_rec', 'FavoritesController@test');

//favoritesテーブルからRecommends表示用のリスト取得(パブリック)
Route::get('/get_recommends', 'FavoritesController@index'); 

//favoritesテーブルにlikeボタンクリックしたコンテンツを登録
Route::post('/register_recommends', 'FavoritesController@store'); 

//favoritesテーブルからdeleteボタンクリックしたコンテンツを削除
Route::delete('/delete_recommends/{id}', 'FavoritesController@destroy');