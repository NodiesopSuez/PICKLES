<template>
    <div>
        <router-link class="to_top" to="/">
            <button>
                <div></div>
                <div></div>
            </button>
        </router-link>
        <div class="login">
            <div class="rid"></div>
            <form class="bin">
                <div>
                    <img src="../img/like.png">
                    <h3>Login</h3>
                </div>
                <div class="form-group">
                    <p>email</p>
                    <input id="email" name="email" v-model="email" type="text">
                </div>
                <div class="form-group">
                    <p>password</p>
                    <input id="password" name="password" v-model="password" type="password">
                </div>
                <button type="submit" class="submit" >Login</button>
           </form>
        </div>
        <section class="modal_section" v-if="modal" :class="status">
            <div class="modal_back"></div>
            <div class="modal_box">
                <div v-if="status=='error'" v-html="error_msg"></div>
                <div v-else-if="status=='registered'" v-html="registered_msg"></div>
                <button @click="closeModal()">Close</button>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: 'Login',
    data: function(){
        return {
            email: '',
            password: '',
            status: 'registered',
            modal: true,
            error_msg:  `<h2>!! ERROR !!</h2><p>エラーが発生いたしました。</p><p>申し訳ございませんが、<br/>再度トップページよりお進みください。</p>`,
            registered_msg: `<h2>Registered!</h2><p>ユーザー登録が完了しました！</p>`,
        }
    }
    
}
</script>

<style scoped>
/* to_topボタン */
.to_top {
    float: right;
    margin: 16px;
}
.to_top button {
    position: relative;
    width: 30px;
    height: 30px;
    box-shadow: none !important;
    transition: unset !important;
    background: transparent !important;
}

.to_top button > div {
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    margin: auto;
    width: 25px;
    height: 5px;
    background: #303030;
}

.to_top button > div:first-of-type {
    transform: rotate(45deg) !important;
}

.to_top button > div:last-of-type {
    transform: rotate(-45deg) !important;
}

/* ログインフォーム */
.login {
    position: relative;
    margin: auto auto 80px auto;
    padding: 50px 0 0 0;
    width: 450px;
    height: 528px;
}

.rid,
.bin {
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
}

/* ふた部分 */
.rid {
    z-index: 10;
    top: 32px;
    width: 392px;
    height: 45px;
    border-radius: 10px;
    background: var(--md-green);
}

/* びん部分 */
.bin {
    bottom: 0;
    padding: 56px 48px;
    width: 400px;
    height: 464px;
    background: #EDFFF0;
    border-radius: 30px;
    border-style: solid;
    border-width: 3px;
    border-color: #fff;
}

.bin > div:first-of-type {
    margin: auto auto 24px auto;
}

.bin img {
    width: 106px;
    margin: auto auto 8px auto;
}

.bin h3 {
    color: var(--md-green); 
}

.form-group,
.form-group * {
    text-align: start;
    background: transparent;
}

.form-group > p {
    margin: 0;
}

.form-group > input {
    width: 280px;
    font-size: 18px;
    border-style: none none solid none;
    border-width: 1px;
    border-color: #b0c5da;
}

.submit {
    z-index: 10;
    margin: 8px !important;
    width: 80px;
    height: 30px;
    line-height: 30px;
    border-radius: 15px;
    font-size: 16px;
    color: #fff;
    background: var(--md-green);
}

.registered > .modal_box {
    top: 0 !important;
}

</style>