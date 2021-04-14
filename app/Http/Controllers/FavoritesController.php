<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorites;

class FavoritesController extends Controller
{
    //favoritesテーブルの全レコード取得(デバック用)
    public function index() {
        $favorites = new Favorites;
        $favorites_list = $favorites -> getFavorites();

        return $favorites_list;
    }
}
