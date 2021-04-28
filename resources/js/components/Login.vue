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
console.log('login入った瞬間');
            //アクセストークン取得
            let body = {
                'grant_type'   : 'password',
                'client_id'    : '2',
                'client_secret': 'lF5CSpUbRHYqqRw7InsLqDiMqsBw9xZPA6aLhZSJ',
                'username'     : this.email,
                'password'     : this.password,
                'scope'        : '',
            }

            axios.post('/oauth/token', body)
            .then((token)=>{
console.log('あくせすとーくん鳥に行ってる');
                //取得できたアクセストークンでログイン
                console.log(token.data);

                let access_token = token.data.access_token;
                let header = { headers: {
                    'Accept' : 'application/json',
                    'Authorization' : `Bearer ${access_token}`,
                }};

                axios.get('/api/user', header)
                .then((user_data) => {
                    //ログイン出来たら、Top.vueを表示
                    console.log(user_data.data);
                    let user_id = user_data.data.id;

                    this.$router.push({ 
                        name: 'user_page',
                        params: { 
                        user_access_token: access_token, 
                        login_status: true,
                        register_or_logind: 2,
                    }});
                })
                .catch((error)=>{
                    //エラーキャッチしたら
                    console.log(error.response)
                    this.switchStatusError(error); 
                    this.modal  = true;
                });
            })
            .catch((error)=>{
                //エラーキャッチしたら
                console.log(error.response)
                this.switchStatusError(error);
            });

        },
        //axiosでエラーキャッチした時
        switchStatusError(error){
            //エラーメッセージを代入
            console.log(error);
            console.log(error.response)


            this.error_msg = [];  //既に入っているメッセージを削除
            this.error_msg = ['emailもしくはpasswordに誤りがあります。'];

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

</style>