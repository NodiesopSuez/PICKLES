# PICKLES
Spotfy APIを用いた音楽検索システム  
ユーザー登録機能、お気に入り機能を利用できます。
<img width="1280" alt="スクリーンショット 2021-08-05 12 13 27" src="https://user-images.githubusercontent.com/76401237/128285761-e54d9241-42e2-435b-af6c-86f790f208ad.png">

## FEATURES
**コンテンツ検索**  
フォームに入力されたキーワードと一致する、アルバムタイトル・トラックタイトル・アーティスト名を検索します。  
検索結果一覧には各アイテムの下記が表示されます。  
- アルバムの場合
    - アルバムタイトル
    - アーティスト名
    - リリース日
    - アルバムのアートワーク(クリックするとSpotifyの該当コンテンツのページを表示します。)
- トラックの場合
    - トラックタイトル
    - 収録アルバムタイトル
    - アーティスト名
    - リリース日
    - 収録アルバムのアートワーク(クリックするとSpotifyの該当コンテンツのページを表示します。)
  
**ユーザー登録機能**  
次の内容をもってユーザー登録することができます。
- ユーザー名
- メールアドレス
- パスワード
  
**Recommendsリスト**  
ユーザー未登録状態で、お気に入りの楽曲をRecommendsにて登録・削除することができます。  
全エンドユーザーが閲覧できます。
  
**Favoritesリスト**  
登録済みユーザーはログイン後、お気に入りの楽曲をFavoritesにて登録・削除することができます。  
このリストはログインした該当ユーザーのみ閲覧可能です。
  
## REQUIREMENT
- laravel : 6.2
- passport
- axios : 0.21.1
- core-js : 3.6.5
- vue : 2.6.11
- vue/cli : 4.5.11
- vue-paginate : 3.6.0
- [Spotify API (Search API)](https://developer.spotify.com/documentation/web-api/reference/#category-search)
## INSTALLATION
passport : `php artisan passport:install`  
axios : `npm install axios@0.21.1`  
vue/cli : `npm install -g @vue/cli`  
vue-paginate : `npm install vuejs-paginate`  
## AUTHOR
* A.AKASHI
* belong to B-FORME  
## LICENSE
PICKLESで使用されている画像について、著作権は下記のように帰属します。
- Top
    - catch_img_hand.png : 作成者 A.AKASHI
    - musical_notes_fortop.png : 作成者 A.AKASHI
- Result
    - 各アルバムアートワーク : Spotify
***
### Compiles and hot-reloads for development
```
npm run serve
```
### Compiles and minifies for production
```
npm run build
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).