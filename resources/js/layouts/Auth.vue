<template>
    <div class="auth">
        <Loader v-if="loader"/>
        <div class="container">
            <div class="auth-wrap">
                <router-view/>
            </div>
        </div>
    </div>
</template>

<script>

    import Loader from "@/components/loader/Loader";
    import CheckViewSkeleton from "@/components/skeleton/CheckViewSkeleton";
    import {mapGetters} from "vuex";

    export default {
        name: 'AuthLayout',
        components: {Loader, CheckViewSkeleton},
        computed: {
            ...mapGetters({
                loader: 'common/loader'
            })
        },
    }
</script>

<style lang="scss" scoped>
    .auth {
        display: flex;
        align-content: center;
        justify-content: center;
        flex-direction: column;
        position: relative;
        height: 100vh;
        overflow-y: hidden;
        top: 0;
        left: 0;
        width: 100%;

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
