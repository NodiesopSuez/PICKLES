<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model {
    protected $table = "favorites";

    //favoritesテーブルの全レコード取得(デバック用)
    public function getFavorites(){
        $favorites = $this -> all();

        return $favorites;
    }

}


?>