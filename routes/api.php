<?php

use Illuminate\Http\Request;
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

Route::get('/get_recommends', function(){
    $favorites = \App\Favorites::all();

    return $favorites;
});

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
