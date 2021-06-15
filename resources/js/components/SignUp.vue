<template>
    <div>
        <router-link class="to_top" to="/">
            <button>
                <div></div>
                <div></div>
            </button>
        </router-link>
        <div class="signup">
            <div class="rid"></div>
            <div class="bin">
                <div>
                    <img src="../img/like.png">
                    <h3>Sign up</h3>
                </div>
                <div class="form-group">
                    <p>name</p>
                    <input id="name" name="name" v-model="name" type="text">
                </div>
                <div class="form-group">
                    <p>email</p>
                    <input id="email" name="email" v-model="email" type="text">
                </div>
                <div class="form-group">
                    <p>password</p> 
                    <input id="password" name="password" v-model="password" type="password">
                </div>
                <button type="submit" class="submit" @click="registerUser()">Sign up</button>
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
    name: 'SignUp',
    data: function(){
        return {
            name: '',
            email: '',
            password: '',
            modal: false,
            status: '',
            error_msg: ['エラーが発生いたしました。', '申し訳ございませんが', '再度トップページよりお進みください'],
        }
    },
    methods: {
        registerUser(){
            //入力された情報
            let params = {
                "name"    : this.name,
                "email"   : this.email,
                "password": this.password,
            };

            
            axios.post('./api/register_user', params)
            .then((token) => {
                // console.log(token.data);
                //登録できたらアクセストークン取得 & ログイン完了
                //ローカルストレージに格納
                localStorage.setItem('user_id', token.data.user_id);
                localStorage.setItem('user_access_token', token.data.access_token);
                localStorage.setItem('user_name', this.name);
                localStorage.setItem('register_or_logind', 1);
                localStorage.setItem('pickles_login', +new Date); //ログイン日時をタイムスタンプで格納
                //Top.vueを表示
                this.$router.push({ path: '/' });
            })
            .catch((error)=>{
                this.error_msg = [];  //既に入っているメッセージを削除

                //エラーメッセージを代入
                let messages = (error.response.data.errors.detail) 
                                ? error.response.data.errors.detail 
                                : null;
                // console.log(error);
                // console.log(messages);
                if(messages){
                    //バリデーションエラーならば
                    //入ってるメッセージをdata.error_msgに追加
                    (messages.name)     ? this.error_msg.push(messages.name[0])    : null;
                    (messages.email)    ? this.error_msg.push(messages.email[0])   : null;
                    (messages.password) ? this.error_msg.push(messages.password[0]): null;
                }else {
                    //バリデーション以外のエラーならば
                    this.error_msg = ['エラーが発生いたしました。', '申し訳ございませんが', '再度情報の入力よりお進みください'];
                }

                this.status = 'error';
                this.modal  = true;   
            });
        },
        //モーダル非表示にする
        closeModal(){
            this.modal ? this.modal=!this.modal : this.modal
        },
    }
    
}
</script>

<style scoped>
/* to_topボタン */
.to_top {
    position: relative;
    float: right;
    margin: 1rem;
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

/* 登録フォーム */
.signup {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 450px;
    height: 538px;
}

.signup,
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
    width: 360px;
    height: 45px;
    border-radius: 10px;
    background: var(--icon-background);
}

/* びん部分 */
.bin {
    bottom: 0;
    padding: 32px 48px;
    width: 380px;
    height: 496px;
    background: #EDFFF0;
    border-radius: 40px;
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

.bin h3,
.submit {
    color: #573100; 
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
    background: var(--icon-background);
    font-size: 16px;
}


@media screen and (max-width: 480px) {
    .to_top {
        margin: 0.5rem;
    }

    .signup {
        width: 20rem;;
        height: 33rem;
    }
    .rid {
        width: 90%;
        top: 0;
    }
    .bin {
        width: 19rem;
        height: 30rem;
        padding: 2.5rem 1rem 1rem 1rem;
    }
    .bin > div:first-of-type {
        margin: auto auto 2.5rem auto;
        width: 11rem;
    }
    .bin img {
        width: 4.5rem;
    }
    .form-group > input {
        width: 100%;
    }
    .bin .submit { 
        margin: 1rem auto auto auto !important;
    }

} 

</style>