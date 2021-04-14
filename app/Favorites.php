<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model {
    protected $table = "favorites";

    //favoritesテーブルの全レコード取得(デバック用)
    public function getFavoritesAll(){
        $favorites = $this -> all();
        return $favorites;
    }

    //favoritesテーブルから特定user_idのレコード取得
    public function getFavoritesByUserId(){
        $favorites = $this -> where("user_id", null)
                -> groupBy(["album_title", "track_title", "artist"])
                -> orderBy("id", "desc")
                -> get();

        return $favorites;
    }

    //favoritesテーブルにlikeボタンクリックしたコンテンツを登録
    public function registerContentsWithFavorites($request){
        $favorites = $this;
        
        $favorites -> type        = $request -> get("type");
        $favorites -> album_title = $request -> get("album_title");
        $favorites -> artist      = $request -> get("artist");
        $favorites -> img         = $request -> get("img");
        $favorites -> end_url     = $request -> get("end_url");
        $favorites -> release     = $request -> get("release");

        $favorites -> track_title = $request -> get("track_title");
        $favorites -> user_id     = $request -> get("user_id");
        
        $favorites -> save(); 

        return 'OK';
    }

    //favoritesテーブルからid指定でコンテンツを削除
    public function deleteContentsFromFavoritesByUserId($id){
        $favorites = $this;
        $delete_contents = $favorites::find($id);
        if($delete_contents){
            $delete_contents -> delete();
        }
        return 'deleted';
    }
}


?>