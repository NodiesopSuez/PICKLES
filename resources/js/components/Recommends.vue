<template>
    <div>
        <div class="recommends_header">
            <div>Recommends</div>
            <div class="back_search">
                <button @click="scrollToTop()"></button>
                <h4>Back to search</h4>
            </div>
            <div class="no_list">
                <h3>まだお気に入りが登録されていません。</h3>
                <p>オススメしたいコンテンツをみんなで共有しよう！</p> 
                <p>検索結果の<button class="like" disabled><img src="../img/like.png"></button></p>
                <p></p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
}
</script>

<style scoped>
/* likeボタン */
.like {
    margin: 2px !important;
    pointer-events: none !important;
}
</style>