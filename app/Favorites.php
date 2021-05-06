<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model {
    protected $table = "favorites";
    
    //protected $attributes = ['user_id' => null];

    //favoritesテーブルの全レコード取得(デバック用)
    public function getFavoritesAll(){
        $favorites = $this::all();
        return $favorites;
    }

    //favoritesテーブルから特定user_idのレコード取得
    public function getFavoritesByUserId(){
        $favorites = $this::where("user_id", null) -> get();

        return $favorites;
    }

    //favoritesテーブルにlikeボタンクリックしたコンテンツを登録
    public function registerContentsWithFavorites($request){
        $favorites = $this;

        $user_id     = $request -> get("user_id");     //null:ゲスト
        $type        = $request -> get("type");        //postされたコンテンツタイプ(album / track)    
        $album_title = $request -> get("album_title"); //postされたアルバムタイトル
        $artist      = $request -> get("artist");      //postされたアーティスト名
        $track_title = $request -> get("track_title"); //postされたトラックタイトル

        //コンテンツのtypeによって重複回避するカラムを分岐
        if($type === "track"){
            //重複したレコードがないか検索
            $exist_track = $this::where("user_id", $user_id)
                                ->where("track_title", $track_title)            
                                ->where("artist", $artist)            
                                ->get();
            
            //重複したレコードがなければ登録メソッドをコール
            if($exist_track->isEmpty()){
                $register_contents = self::registerContents($request);
            }else{
                return 'duplicate';
            }
        }else{
            //重複したレコードがないか検索
            $exist_album = $this::where("user_id", $user_id)
                                ->where("album_title", $album_title)            
                                ->where("artist", $artist)            
                                ->get();
            
            //重複したレコードがなければ登録メソッドをコール
            if($exist_album->isEmpty()){
                $register_contents = self::registerContents($request);
            }else{
                return 'duplicate';
            }
        } 
        return $register_contents;
    }
    
    
    public function registerContents($request) {
        $favorites = $this;

        $favorites -> type         = $request -> get("type");
        $favorites -> album_title  = $request -> get("album_title");
        $favorites -> artist       = $request -> get("artist");
        $favorites -> img          = $request -> get("img");
        $favorites -> external_url = $request -> get("external_url");
        $favorites -> release      = $request -> get("release");
        
        $favorites -> track_title  = $request -> get("track_title");
        $favorites -> user_id      = $request -> get("user_id");
        
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