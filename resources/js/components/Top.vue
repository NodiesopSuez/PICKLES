<template>
    <div>
       <!-- <router-link to="/example">To Example</router-link>
       <br/> -->
       <!-- トップ -->
        <section class="top_section">
            <div class="menu">
                <nav>
                    <ul v-if="login_status==true">
                        <li class="logout" @click="logout()">Logout</li>
                        <li><img src="../img/logind.png"><p class="user_name">{{ user_name }}</p></li>
                    </ul>
                    <ul v-else>
                        <li><router-link to="login">Login</router-link></li>
                        <li><router-link to="signup">Sign up</router-link></li>
                        <li><img src="../img/not_login.png"></li>
                    </ul>
                    
                </nav>
            </div>
            <div class="catch">
                <img class="catch_img_hand" src="../img/catch_img_hand.png">
                <h1>PICKLES</h1>
                <p>pick up for listening</p>
            </div>
            <div class="search_form">
                <input type="text" name="word" v-model="keyword" placeholder="Enter the words">
                <button type="submit" class="submit" @click="searchInfo()">Pick up</button>
            </div>
            <button class="to_recommends">
                <router-link to="/recommends">
                    <div><img src="../img/recommend_default.png"></div>
                    <div>Recommends</div>
                </router-link>
            </button>
            <img class="musical_notes" src="../img/musical_notes_fortop.png">
        </section>
        <!-- 検索結果リスト -->
        <section id="result_section" ref="result_section" v-if="toggle">
            <div class="back_search">
                <button @click="scrollToTop()"></button>
                <h4>Back to search</h4>
            </div>
            <div class="result">
                <paginate name="paginate-items" tag="div" :list="result_list" :per="5">
                    <div class="result_li" v-for="(music, index) in paginated('paginate-items')" :key="index">
                        <a target="_blank" rel="noopener" :href="music.external_url"><img :src="music.img"></a>
                        <ul>
                            <li v-if="music.type=='track'"> {{ music.track_title }}</li>
                            <li> {{ music.album_title }} </li>
                            <li> {{ music.artist }} </li>
                            <li> {{ music.release }} <button class="like" @click="registerRecommends(music)"><img src="../img/like.png"></button></li>
                        </ul>
                    </div>
                </paginate>
                
            </div>
            <paginate-links for="paginate-items" 
                            class="pagination" 
                            :limit="5"
                            :show-step-links="true">
            </paginate-links>
        </section>
        <!-- モーダル部分 -->
        <section class="modal_section" v-if="modal" :class="[status]">
            <div class="modal_back"></div>
            <div class="modal_box">
                <div v-if="status=='error'" v-html="error_msg"></div>
                <div v-else-if="status=='no_result'" v-html="no_result_msg"></div>
                <div v-else-if="status=='duplicate'" v-html="duplicate_msg"></div>
                <div v-else-if="status=='success'" v-html="success_msg"></div>
                <div v-else-if="status=='success logged_in'" v-html="success_msg"></div>
                <button @click="closeModal()">Close</button>
            </div>
        </section>
    </div>
</template>


<script>
import axios from 'axios'
import Paginate from 'vue-paginate'
import Vue from 'vue'

Vue.use(Paginate);

export default {
    name: 'Top',
    data: function(){
        return{
            keyword: '',     //入力された検索ワード
            toggle: false,   //Resultの表示・非表示
            modal: false,    //モーダルの表示・非表示
            
            login_status: false, //ログインしているかどうか
            icon_img: '',        //ヘッダーメニューのアイコン画像
            user_name: '',       //ユーザー名

            albums_info: [], //検索結果：アルバムのリスト
            tracks_info: [], //検索結果：トラックのリスト
            result_list: [], //検索結果：表示用リスト(アルバム→トラック)

            status: '',  //モーダルのスタイル・メッセージのステータス(error/no_result/duplicate/success)
            //各ステータスメッセージ内容
            error_msg: `<h2>!! ERROR !!</h2><p>エラーが発生いたしました。</p><p>申し訳ございませんが、<br/>再度トップページよりお進みください。</p>`,
            no_result_msg: ``,
            duplicate_msg: `<h2>!! ERROR !!</h2><p>選ばれたコンテンツは<br/>既に登録されています。<br/>他のコンテンツをお選びください。`,
            success_msg: ``,
                    //↑↑↑
                    //Recommendsに追加出来た時： success_msg: `<h2>Registered!</h2><p>Recommendsリストに登録されました！</p>`,
                    //ログイン出来た時：`<h2>HI!userさん！</h2><p>ログインできました！</p>`,
                    //ユーザー登録出来た時：<h2>Registered!</h2><p>ユーザー登録できました！</p>

            paginate:['paginate-items'], //paginate用
        }
    },
    mounted: function(){
        //Spotify/アクセストークン取得
        const grant_type = {'grant_type': 'client_credentials'};
        const body = new URLSearchParams(grant_type);
        const header = { headers: {
                            'Authorization': 'Basic MjQ2M2FjMTIzYjU5NDcwOWE5OThhZDg5NWEyNzIxN2U6OTMyMGY3MWRmYTdmNDA0OGFkYzQzN2RkM2JmMDAyNTA=',
                            'Content-Type' : 'application/x-www-form-urlencoded',
                        }};
        var self = this;

        axios.post('https://accounts.spotify.com/api/token', body, header)
            .then(function(token_res){
                //取得出来たSpotifyアクセストークン
                console.log(token_res.data.access_token);
                self.access_token = token_res.data.access_token;

                //ログインしていたらユーザー情報取得
                if(localStorage.user_access_token){
                    console.log('localStorage');
                    console.log(localStorage.user_access_token);
                    console.log(localStorage.user_name);
                    console.log(localStorage.register_or_logind);

                    let user_access_token  = localStorage.user_access_token;
                    self.login_status      = true;
                    self.user_name         = localStorage.user_name;

                    //ユーザー登録後かログイン後の遷移ならばモーダル表示
                    if(localStorage.register_or_logind){
                        if(localStorage.register_or_logind == 1){        //ユーザー登録後
                            self.success_msg = `<h2>Registered!</h2><p>ようこそ${ self.user_name }さん！</p><p>ユーザー登録できました！</p>`;
                        }else if(localStorage.register_or_logind == 2){　//ログイン後
                            self.success_msg = `<h2>HI!${ self.user_name }さん！</h2><p>ログインできました！</p>`;
                        }
                        localStorage.clear('register_or_logind');
                        self.status = 'success logged_in';
                        self.modal  = true;  
                    }
                }
            })
            .catch(function(error){
                //エラーキャッチしたら
                console.log(error);
                self.toggle = false;
                self.modal = true;
                self.status = 'error';
                return;
            })
    },
    methods: {
        searchInfo(){
            //検索結果0の時のメッセージ
            this.no_result_msg = `<h2>ERROR!!</h2><p class="keyword">キーワード：${this.keyword} </p><p>検索結果が見つかりませんでした。<br/>他のキーワードで検索してください。</p>`;
            
            //キーワードが入力されてなければ、エラーモーダル表示    
            if(this.keyword==""){
                this.toggle = false;
                this.modal = true;
                this.status = 'no_result';
                return;
            }


            self = this;

            //キーワードで検索
            let search_type = 'album,track,artist';
            let search_limit = '50';

            axios.get(`https://api.spotify.com/v1/search?q=${this.keyword}&type=${search_type}&limit=${search_limit}`, 
                {headers: {
                        'Authorization': 'Bearer ' +  self.access_token,
                }})
                .then((search_res)=>{ 
                    this.result_list = [];
                    //デバッグ用にconsoleに出力
                    console.log('search_res');
                    console.log(search_res);
                    console.log(search_res.data);

                    //検索結果が0ならば、エラーモーダル表示
                    let album_total = search_res.data.albums.total;
                    let track_total = search_res.data.tracks.total;
                    let artist_total = search_res.data.artists.total;
                    /* if((album_total === 0) && (track_total === 0) && (artist_total === 0)) */
                    if((album_total + track_total + artist_total)===0){
                        this.toggle = false;
                        this.modal = true;
                        this.status = 'no_result';
                        return;
                    }else{
                        this.toggle = true;
                    }

                    /* アルバム情報取得 */
                    let albums = search_res.data.albums.items;

                    let album, album_info;
                    for(let i = 0; i < albums.length; i ++){
                        album = albums[i];
                        album_info = {
                            "type": 'album',
                            "album_title": album.name,
                            "artist": album.artists[0].name,
                            "release": album.release_date,
                            "img": album.images[1].url,
                            "external_url": album.external_urls.spotify
                        }
                        this.albums_info.push(album_info);
                        this.result_list.push(album_info);
                    }
                //デバッグ用にconsoleに出力
                console.log('albums');
                console.log(this.albums_info);

                    /* トラック情報取得 */
                    let tracks = search_res.data.tracks.items;
                    
                    let track, track_info;
                    for(let i = 0; i < albums.length; i ++){
                        track = tracks[i];
                        track_info = {
                            "type": 'track',
                            "track_title": track.name,
                            "album_title": track.album.name,
                            "artist": track.artists[0].name,
                            "release": track.album.release_date,
                            "img": track.album.images[1].url,
                            "external_url": track.external_urls.spotify
                        }
                        this.tracks_info.push(track_info);
                        this.result_list.push(track_info);
                    }
                //デバッグ用にconsoleに出力  
                console.log('tracks');
                console.log(this.tracks_info);
                })
                .catch((error)=>{
                    this.toggle = false;
                    this.modal = true;
                    this.status = 'error';
                    return;
                })
                .finally(()=>{
                    if(this.toggle){
                        this.scrollToResultSection();
                    }
                    return;
                })
        },
        scrollToTop(){
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        },
        scrollToResultSection(){
            const result_section = this.$refs.result_section;
            const result_section_rect = result_section.getBoundingClientRect();
            var y_offset = window.pageYOffset + result_section_rect.top
            window.scrollTo({
                top: y_offset,
                behavior: 'smooth',
            })
        },
        closeModal(){
            this.modal ? this.modal=!this.modal : this.modal
        },

        //クリックされたLikeボタンの楽曲をRecommendsリストに追加
        registerRecommends(music){
            this.loggedIn = false; //モーダルの位置変える
            let track_title = (music.type === "track") ? music.track_title : null;

            let post_data = {
                'type'         : music.type,
                'track_title'  : music.track_title,
                'album_title'  : music.album_title,
                'artist'       : music.artist,
                'img'          : music.img,
                'external_url' : music.external_url,
                'release'      : music.release,
            }

            axios.post(`./api/register_recommends`, post_data)
            .then((response) => {
                //デバッグ用にconsole出力
                console.log(response);

                //登録できてたら'OK' / 重複したレコードあれば'duplicate'
                if(response.data === 'OK'){
                    this.status = 'success';
                    this.success_msg = `<h2>Registered!</h2><p>Recommendsリストに登録されました！</p>`;
                }else if(response.data === 'duplicate'){
                    this.status = 'duplicate';
                }else{
                    this.status = 'error';
                    this.scrollToTop();
                }
            })
            .catch((error)=>{
                this.toggle = false;
                    this.modal = true;
                    this.status = 'error';
                    this.scrollToTop();
                    return;
            })
            .finally(()=>{
                this.modal = true;
                return;
            })
        },
        logout(){
            //ローカルストレージからユーザー情報削除
            localStorage.removeItem('access_token');
            localStorage.removeItem('user_name');
            localStorage.removeItem('register_or_logind');
            this.toggle = false;
            this.success_msg = `<h2>Logouted!</h2><p>ログアウトできました</p>`;
            this.modal  = true;
            this.login_status = false,
            this.status = 'success logged_in';
            return;
        }
    },
}
</script>

<style>
/* likeボタン */
.like,
.delete {
    margin-left: 5px !important;
    padding: 0 0 4px 0;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #fff;
}

.like > img,
.delete > img {
    width: 18px;
    margin: auto auto 6px auto;
}

/* Recommendsボタン */
.to_recommends {
    display: block;
    position: relative;
    width: 156px;
    height: 40px;
    border-radius: 20px;
}

.to_recommends div {
    position: absolute;
    top: 0;
    color: #fff;
}

.to_recommends div:first-child {
    left: -0.5px;
    padding: 4px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--icon-background);
}

.to_recommends div:first-child img {
    height: 32px;
    margin: auto;
}

.to_recommends div:nth-child(2) {
    line-height: 40px;
    right: 10px;
}

/* section */.top_section {
    height: 600px;
    background: linear-gradient(to bottom, #fff 53%, var(--for-background) 47% 100%) ;
}

.top_section button {
    font-size: 16px;
    background: var(--md-green);
    color: #fff;
}

.catch,
.musical_notes {
    position: relative;
    margin: auto;
}

.catch *,
.musical_notes > img {
    position: absolute;
}

.catch {
    width: 480px;
    height: 286px;
}

.catch_img_hand {
    bottom: 0;
    right: 0;
    left: 0;
    margin: auto;
    width: 240px;
}

.catch > h1,
.catch > p {
    color: var(--md-yellow);
}

.catch > h1 {
    bottom: 108px;
    font-size: 50px;
    font-weight: bold;
}

.catch > p {
    bottom: 80px;
    font-size: 20px;
}

.musical_notes {
    margin: auto;
    width: 1000px;
}

/* menu部分---------------------------------------------------------- */
.menu > nav {
    padding: 16px 24px 0 0;
}

.menu ul {
    display: flex;
    justify-content: flex-end;
    align-items: flex-end;
    width: 264px;
    margin: auto 0 auto auto;
}

.menu li {
    margin: auto 0  0 16px;
}

.menu li > a,
.menu li {
    cursor: pointer;
    font-size: 16px;
    color: #FFE669;
}

.menu li > a:hover,
.menu li:hover  {
    color: #573100;
    text-decoration: none;
}

.menu li:last-child {
    text-align: end;
}

.menu li > img {
    width: 40px;
}

.menu .user_name {
    margin: 0;
    font-size: 11px;
    color: #ff9100;
}

.menu .logout {
    padding-bottom: 11px;
}


/* Form部分 --------------------------------------------------------- */
.search_form { 
    display: flex;
    justify-content: space-between;
    margin: 30px auto;
    width: 480px;
}

input {
    border: none;
    outline: none;
    text-align: center;
}

input[name="word"],
.submit {
    height: 30px;
    line-height: 30px;
    border-radius: 15px;
}

input[name="word"] {
    margin-top: 4px;
    width: 370px;
    color: var(--md-green);
    font-size: 18px;
    background: #fff;
}

::placeholder {
    color: #698966;
    background: #fff;
}

.submit {
    z-index: 10;
    margin-bottom: 4px!important;
    width: 80px;
}

/* Result部分 --------------------------------------------------------- */
/* section */#result_section {
    display: flex;
    flex-direction: column;
    margin-top: 50px;
    padding-top: 16px;
    background-color: var(--for-background);
}

.back_search button {
    position: relative;
    margin: auto 8px 4px auto !important;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: #fff;
}

.back_search button::after {
    position: absolute;
    content: '';
    top: -2px;
    right: 8px;
    left: 6px;
    margin: auto;
    border-style: solid;
    border-width: 7px 7px 14px 7px;
    border-color: transparent transparent var(--md-green) transparent;
}

.back_search h4 {
    margin: 8px auto 16px auto;
    color: var(--md-green);
}

.result > div,
.result_li,
.pagination {
    display: flex;
    align-items: center;
}

.result > div {
    flex-wrap: wrap;
    justify-content: space-between;
    width: 800px;
    margin: auto;
}

.result_li {
    width: 370px;
    justify-content: flex-start;
    margin: 20px 20px 20px 0px ;
    text-align: start;
}

.result_li a > img {
    width: 130px;
    height: 130px;
    background: #ccc;
    box-shadow: 5px 5px 2px var(--shadow);
}

.result_li li:first-child{
    font-size: 16px !important;
    margin-bottom: 4px;
    font-weight: bold;
}

.result_li li:last-child{
    line-height: 30px;
}

.result_li > ul {
    font-size: 14px;
}

.pagination {
    cursor: pointer;
    margin: 20px auto 100px auto;
}
.pagination .number,
.pagination .right-arrow,
.pagination .left-arrow {
    color: var(--md-green);
    margin: auto 6px;
}
.pagination .disabled {
    opacity: 0;
}
.pagination .active {
    width: 25px;
    height: 25px;
    color: #fff!important;
    background: var(--md-green);
    padding-top: 2px;
    border-radius: 50%;
}
</style>