<template>
    <div class="recommends">
        <div class="recommends_header">
            <h4>Recommends</h4>
            <div class="back_search">
                <router-link to="/"><button></button></router-link>
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
                    <router-link to="/"><button></button></router-link>
                    <h4>Let's search!!</h4>
                </div>
            </div>
            <div class="recommends_img">
                <img src="../img/for_recommends.png">
            </div>           
        </div>
        <section id="result_section" ref="result_section" v-if="toggle">
            <div class="result">
                <paginate name="paginate-items" tag="div" :list="recommends_list" :per="5">
                    <div class="result_li" v-for="(music, index) in paginated('paginate-items')" :key="index">
                        <img :src="music.img">
                        <ul>
                            <li v-if="music.type=='track'"> {{ music.track_title }}</li>
                            <li> {{ music.album_title }} </li>
                            <li> {{ music.artist }} </li>
                            <li> {{ music.release }} <button class="delete"><img src="../img/delete.png"></button></li>
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
                <p>エラーが発生しました。<br/>
                   申し訳ございませんが、<br/>
                   トップページへお戻りください。</p>
                <router-link><button>トップページへ</button><router-link>
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
    name: 'Recommend',
    data: function(){
        return {
            modal: true,
            toggle: true,
            recommends_list: [],
            paginate:['paginate-items'],
        };
    },
    mounted: function(){
        axios.get('./api/get_recommends')
        .then((response) => {
            this.recommends_list = response.data;
            console.log(response);
        })
        .catch((error)=>{
            this.modal = true;
            return;
        })
        
    }
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
    margin-right: 16px;
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

.back_search button::after {
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