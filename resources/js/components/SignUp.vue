<template>
    <div class="login">
        <div class="bin">
        <div class="rid"></div>
            <form>
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
.login {
    margin: 100px auto;
    width: 450px;
    height: 500px;
}

.bin {
    position: relative;
    width: 400px;
    height: 500px;
}

/* ふた部分 */
.rid {
    position: absolute;
    content: '';
    top: 0;
    left: 0;
    right: 0;
    margin: auto;
    width: 450px;
    height: 30px;
    background: var(--icon-background);
}

</style>