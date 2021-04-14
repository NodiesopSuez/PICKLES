<?php

namespace App;

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

}


?>