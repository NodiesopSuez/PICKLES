<template>
    <div>
       <!-- <router-link to="/example">To Example</router-link>
       <br/> -->
        <section class="top_section">
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
        <section id="result_section" ref="result_section" v-if="toggle">
            <div class="back_search">
                <button @click="scrollToTop()"></button>
                <h4>Back to search</h4>
            </div>
            <div class="result">
                <paginate name="paginate-items" tag="div" :list="result_list" :per="5">
                    <div class="result_li" v-for="(music, index) in paginated('paginate-items')" :key="index">
                        <img :src="music.img">
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
        <section class="modal_section" v-if="modal">
            <div class="modal_back"></div>
            <div class="modal_box">
                <h2>ERROR!!</h2>
                <p>キーワード：{{ keyword }}</p>
                <p>検索結果が見つかりませんでした。<br/>
                 他のキーワードで検索してください。</p>
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
            /* musical_notes_img: '../img/musical_notes_fortop.png', */
            text: '',
            keyword: '',
            access_token: '',
            toggle: false,
            modal: false,
            albums_info: [],
            tracks_info: [],
            result_list: [],

            paginate:['paginate-items'],

        }
    },
    mounted: function(){
        //アクセストークン取得
        const grant_type = {'grant_type': 'client_credentials'};
        const body = new URLSearchParams(grant_type);
        const header = {headers: {
                            'Authorization': 'Basic MjQ2M2FjMTIzYjU5NDcwOWE5OThhZDg5NWEyNzIxN2U6OTMyMGY3MWRmYTdmNDA0OGFkYzQzN2RkM2JmMDAyNTA=',
                            'Content-Type' : 'application/x-www-form-urlencoded',
                        }};
        var self = this;
        axios.post('https://accounts.spotify.com/api/token', body, header)
            .then(function(token_res){
                //デバッグ用にconsoleに出力
                console.log(token_res.data.access_token);
                self.access_token = token_res.data.access_token;
            })
            .catch(function(error){
                //デバッグ用にconsoleに出力
                console.log(error);
                self.toggle = false;
                self.modal = true;
                return;
            })
    },
    methods: {
        searchInfo(){
            self = this;
             //デバッグ用にconsoleに出力
            console.log(this.keyword);

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

                    //検索結果が0ならば
                    let album_total = search_res.data.albums.total;
                    let track_total = search_res.data.tracks.total;
                    let artist_total = search_res.data.artists.total;

                    console.log(album_total + track_total + artist_total);

                    /* if((album_total === 0) && (track_total === 0) && (artist_total === 0)) */
                    if((album_total + track_total + artist_total)===0){
                        this.toggle = false;
                        this.modal = true;
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
            let track_title = (music.type === "track") ? music.track_title : null;

            let post_data = {
                'type'        : music.type,
                'track_title' : music.track_title,
                'album_title' : music.album_title,
                'artist'      : music.artist,
                'img'         : music.img,
                'end_url'     : music.external_url,
                'release'     : music.release,
            }

            axios.post(`./api/register_recommends`, post_data)
            .then(response => {
                console.log(response);
            })
            .catch((error)=>{
                    this.toggle = false;
                    this.modal = true;
                    return;
            })
            .finally(()=>{
                return;
            })
        },
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
    height: 340px;
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

.result_li > img {
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

/* modalt部分 --------------------------------------------------------- */
.modal_back {
    z-index: 20;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #333;
    opacity: 0.8;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal_box {
    z-index: 30;
    position:absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto;
    padding: 16px;
    width: 328px;
    height: 200px;
    border-radius: 15px;
    background: #ccc;
}

h2 {
    margin: 8px auto;
    color: red;
}

.modal_box > button {
    width: 80px;
    height: 35px;
    border-radius: 17.5px;
    font-size: 18px;
    box-shadow: 3px 4px 0px #333;
}
</style>