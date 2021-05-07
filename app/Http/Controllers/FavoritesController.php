<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorites;

class FavoritesController extends Controller
{
    
    //favoritesテーブルの全レコード取得(デバック用)
    public function test() {
        $favorites = new Favorites;
        $favorites_list = $favorites -> getFavoritesAll();
        
        return $favorites_list;
    }
    
    //favoritesテーブルから特定user_idのリストを取得
    public function index($user_id) {
        $favorites = new Favorites;
        $favorites_list_by_userid = $favorites -> getFavoritesByUserId($user_id);
        
        return $favorites_list_by_userid;
    }
    
    //favoritesテーブルにlikeボタンクリックしたコンテンツを登録
    public function store(Request $request) {
        $favorites = new Favorites;
        $register_favorite_contents = $favorites -> registerContentsWithFavorites($request);
        
        return $register_favorite_contents;
    }

    public function destroy($id){
        $favorites = new Favorites;
        $delete_contents_by_userid = $favorites -> deleteContentsFromFavoritesByUserId($id);
        
        return $delete_contents_by_userid;
    }
    
}
