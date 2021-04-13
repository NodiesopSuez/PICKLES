<?php

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

//Recommendsに表示するリスト(パブリック)
Route::get('/get_recommends', function(){
    //user_id===nullで、album_title,track_title,artistでグループ化したリストを取得
    $favorites = \App\Favorites::where("user_id", null)
                ->groupBy(["album_title", "track_title", "artist"])
                ->get();

    return $favorites;
});


Route::get('/get_rec', function(){
    $favorites = \App\Favorites::all();

    return $favorites;
});

//favoritesテーブルに登録(パブリック)
Route::post('/register_recommends', function(){
    $favorites = new \App\Favorites();
 
    $favorites -> type        = request()->get("type");
    $favorites -> album_title = request()->get("album_title");
    $favorites -> artist      = request()->get("artist");
    $favorites -> img         = request()->get("img");
    $favorites -> end_url     = request()->get("end_url");
    $favorites -> release     = request()->get("release");

    $favorites -> track_title = request()->get("track_title");
    $favorites -> user_id     = request()->get("user_id");

    $favorites -> save(); 

    return 'OK';
    
});
