# pickles
Spotfy APIを用いた音楽検索システム
## FEATURES
フォームに入力されたキーワードと一致する
アルバムタイトル・トラックタイトル・アーティスト名を検索します。
検索結果一覧には各アイテムの下記が表示されます。
- アルバムの場合
    - アルバムタイトル
    - アーティスト名
    - リリース日
    - アルバムのアートワーク
- トラックの場合
    - トラックタイトル
    - 収録アルバムタイトル
    - アーティスト名
    - リリース日
    - 収録アルバムのアートワーク
## REQUIREMENT
- axios : 0.21.1
- core-js : 3.6.5
- vue : 2.6.11
- vue/cli : 4.5.11
- vue-paginate : 3.6.0
- [Spotify API (Search API)](https://developer.spotify.com/documentation/web-api/reference/#category-search)
## INSTALLATION
axios : `npm install axios@0.21.1`
vue/cli : `npm install -g @vue/cli`
vue-paginate : `npm install vuejs-paginate`
## AUTHOR
* A.AKASHI
* belong to B-FORME
* e-mail
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