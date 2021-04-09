<template>
    <div class="recommends">
        <div class="recommends_header">
            <h4>Recommends</h4>
            <div class="back_search">
                <button @click="scrollToTop()"></button>
                <h4>Back to search</h4>
            </div>
        </div>
        <div class="no_list">
            <div class="msg">
                <h4>まだお気に入りが登録されていません。</h4>
                <p>オススメしたいコンテンツをみんなで共有しよう！</p> 
                <p>検索結果の<button class="like" disabled><img src="../img/like.png"></button>をクリックして</p>
                <p>Recommendsリストに追加しましょう！</p>
                <div class="back_search">
                    <button @click="scrollToTop()"></button>
                    <h4>Back to search</h4>
                </div>
            </div>
            <div class="recommends_img">
                <img src="../img/for_recommends.png">
            </div>           
        </div>
        <section id="result_section" ref="result_section" v-if="toggle">
            <div class="result">
                <paginate name="paginate-items" tag="div" :list="recommends_list" :per="5">
                    <div class="result_li" v-for="(n, index) in paginated('paginate-items')" :key="index">
                        <img :src="n.img">
                        <ul>
                            <li v-if="n.type=='track'"> {{ n.track_title }}</li>
                            <li> {{ n.album_title }} </li>
                            <li> {{ n.artist }} </li>
                            <li> {{ n.release }} <button class="delete"><img src="../img/delete.png"></button></li>
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
    </div>
</template>

<script>
import axios from 'axios'
import Paginate from 'vue-paginate'
import Vue from 'vue'

Vue.use(Paginate);

export default {
    name: 'Recommend',
    data: function(){
        return {
            toggle: true,
            recommends_list: [
                { "type": 'album',
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'album',
                            "album_title": 'BESTFICTION',
                            "artist": "安室奈美恵",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'track',
                            "track_title": "aoi",
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'album',
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'track',
                            "track_title": "aoi",
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'album',
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'album',
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'track',
                            "track_title": "aoi",
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'album',
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'album',
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'album',
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},
                { "type": 'album',
                            "album_title": '834.194',
                            "artist": "サカナクション",
                            "release": "2021.04.09",
                            "img": "../img/like.png",
                            "external_url": "http://kokoko.com"},

            ],
            paginate:['paginate-items'],
        };
    },
}
</script>

<style scoped>
.recommends {
    width: 800px;
    margin: auto;
}

h4 {
    margin: 0;
}

.recommends_header,
.back_search,
.no_list { 
    display: flex;
    justify-content: flex-start;
}

.recommends_header {
    align-items: flex-end;
    height: 100px;
    margin-bottom: 60px;
}

.recommends_header > h4 {
    position: relative;
    width: 184px;
    height: 58px;
    color: var(--md-green);
    line-height: 58px;
    background: #fff;
}

.recommends_header > h4::after {
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    margin: auto;
    content: '';
    width: 159px;
    height: 47px;
    border: dashed 1px var(--md-green); 
}

.back_search {
    align-items: center;
    width: 190px;
}

.back_search > button::after {
    top: 2px;
    left: 0;
    right: 10px;
    transform: rotate(-90deg);
}

.no_list {
    height: 400px; 
}

.no_list > div {
    width: 50%;
}

.msg {
    text-align: start;
}

.msg > h4 {
    font-weight: bold;
}

.msg > p {
    margin-bottom: 3px;
}

.msg > .back_search {
    margin-top: 20px; 
}

.msg > .back_search button {
    margin: auto 8px auto 0px !important;
}

/* likeボタン */
.like {
    margin: 2px !important;
    pointer-events: none !important;
}

.like img {
    margin: 0 !important;
}

.recommends_img {
    position: relative;
}

.recommends_img::after,
.recommends_img > img {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
}

.recommends_img::after {
    z-index: 10;
    content: '';
    width: 400px;
    height: 400px;  
    border-radius: 50%;
    background: var(--icon-background);
}

.recommends_img > img {
    z-index: 20;
    width: 300px;
}
</style>