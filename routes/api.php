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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', function(){
    //受け取ったjsonデータをdecode
    $request_body = file_get_contents('php://input');
    $decode = json_decode($request_body, true);
    
    /*  $favorites = new \App\Favorites();

    $favorites -> type        = request() -> get("type");
    $favorites -> album_title = request() -> get("album_title");
    $favorites -> artist      = request() -> get("artist");
    $favorites -> artwork     = request() -> get("artwork");
    $favorites -> end_url     = request() -> get("end_url");
    $favorites -> release     = request() -> get("release");

    $favorites -> track_title = request() -> get("track_title");
    $favorites -> user_id     = request() -> get("user_id");

    $favorites -> save(); */

    return 'OK';
    
});
