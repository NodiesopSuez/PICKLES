<?php

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use \App\Http\Controllers\FavoritesController;
use \App\Favorites;

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

//favoritesテーブルの全レコード取得(デバック用)
Route::get('/get_rec', 'FavoritesController@test');

//favoritesテーブルからRecommends表示用のリスト取得(パブリック)
Route::get('/get_recommends', 'FavoritesController@index'); 

//favoritesテーブルに登録(パブリック)
/* Route::post('/register_recommends', function(){
    $favorites = new \App\Favorites();
 
    $favorites -> type        = request() -> get("type");
    $favorites -> album_title = request() -> get("album_title");
    $favorites -> artist      = request() -> get("artist");
    $favorites -> img         = request() -> get("img");
    $favorites -> end_url     = request() -> get("end_url");
    $favorites -> release     = request() -> get("release");

    $favorites -> track_title = request() -> get("track_title");
    $favorites -> user_id     = request() -> get("user_id");
    
    $favorites -> save(); 

    return 'OK';
    
}); */
Route::post('/register_recommends', 'FavoritesController@store'); 

Route::delete('/delete_recommends/{id}', function($id){
    $album_title = request() -> get("album_title");
    $track_title = request() -> get("track_title");
    $artist      = request() -> get("artist");

    $delete_contents = \App\Favorites::where("user_id", null)
                        -> where("album_title", $album_title)
                        -> where("track_title", $track_title)
                        -> where("artist", $artist)
                        -> get();
    if($delete_contents){
        foreach($delete_contents as $content){
            $content -> delete();
        }
    }
    return 'deleted';
});
