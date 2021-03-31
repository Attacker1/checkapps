<template>
    <div class="auth">
        <div class="container">
            <flash-message class="flash-auth"></flash-message>
            <div class="auth-wrap">
                <router-view/>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'AuthLayout',
    }
</script>

<style lang="scss" scoped>
    .auth {
        display: flex;
        align-content: center;
        justify-content: center;
        flex-direction: column;
        position: relative;
        min-height: 100vh;

        &-wrap {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }

    .flash-auth {
        max-width: 410px;
        width: 100%;
        margin: auto;
    }
</style>
