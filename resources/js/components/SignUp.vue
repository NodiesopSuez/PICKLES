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
                <div class="form-group">
                    <p>name</p>
                    <input id="name" name="name" type="text">
                </div>
                <div class="form-group">
                    <p>email</p>
                    <input id="email" name="email" type="text">
                </div>
                <div class="form-group">
                    <p>password</p>
                    <input id="password" name="password" type="password">
                </div>
           </form>
        </div>
    </div>
</template>

<script>
export default {
    
}
</script>

<style scoped>
/* to_topボタン */
.to_top {
    float: right;
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

.login {
    margin: 100px auto;
    width: 450px;
    height: 500px;
}

.bin {
    width: 400px;
    height: 500px;
    background: #EDFFF0;
    border-style: solid;
    border-width: 3px;
    border-color: #fff;
}

/* ふた部分 */
.rid {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    margin: auto;
    width: 450px;
    height: 30px;
    background: var(--icon-background);
}

</style>