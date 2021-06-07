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
            <div class="bin">
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
                <button type="submit" class="submit" @click="login()" >Login</button>
            </div>
        </div>
        <section class="modal_section" v-if="modal" :class="status">
            <div class="modal_back"></div>
            <div class="modal_box">
                <div v-if="status=='error'">
                    <h2>!! ERROR !!</h2>
                    <p v-for="(msg, index) in error_msg" :key="index">{{ msg }}</p>
                </div>
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
            modal: false,
            status: '',
            error_msg: ['エラーが発生いたしました。', '申し訳ございませんが', '再度トップページよりお進みください'],
        }
    },
    methods: {
        login(){
            //入力されたデータ
            let params = {
                "email": this.email,
                "password": this.password,
            }

            axios.post('./api/user_login', params)
            .then((response)=>{
                //console.log(response.data);

                //アクセストークン取得してログインできたら
                //ローカルストレージに格納
                localStorage.setItem('user_id', response.data.user_id);
                localStorage.setItem('user_access_token', response.data.access_token);
                localStorage.setItem('user_name', response.data.user_name);
                localStorage.setItem('register_or_logind', 2);
                localStorage.setItem('pickles_login', +new Date); //ログイン日時をタイムスタンプで格納
                //Top.vueを表示
                this.$router.push({ path: '/' });
            })
            .catch((error)=>{
                //エラーキャッチしたら
                this.switchStatusError(error);
            });

        },
        //axiosでエラーキャッチした時
        switchStatusError(error){
            //エラーメッセージを代入
            //console.log(error);
            //console.log(error.response);
            
            this.error_msg = [];  //既に入っているメッセージを削除
            let error_code = error.response.data.errors.code;
            if(error_code == 404){
                this.error_msg = ['まだ該当メールアドレスでの', '登録がされていません。'];
            }else if(error_code == 401){
                this.error_msg = ['emailもしくはpasswordに誤りがあります。'];
            }

            this.status = 'error';
            this.modal  = true;
        },
        //モーダル非表示にする
        closeModal(){
            this.modal ? this.modal=!this.modal : this.modal
        },
    },
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

.modal_box {
    height: 176px !important;
}


@media (max-width: 767px) {
    .sign_up {
        width: 90%;
        height: 535px;
        top: 70px;
    }
    .rid {
        width: 90%;
        top: 0;
    }
    .bin {
        width: 95%;
        padding: 30px;
    }
    .bin img {
        width: 40%;
    }
    .form-group > input {
        width: 100%;
    }

}

</style>