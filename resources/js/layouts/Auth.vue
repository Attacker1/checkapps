<template>
    <div class="auth">
        <div class="container" >
            <div class="auth-wrap">
<!--                <SkeletonBox height="349px" width="410px" border-radius="6px" v-if="loader" />-->
                <router-view />
            </div>
        </div>
    </div>
</template>

<script>

    import Loader from "@/components/loader/Loader";
    import SkeletonBox from '@/components/skeleton/SkeletonBox';
    import {mapGetters} from "vuex";

    export default {
        name: 'AuthLayout',
        components: {SkeletonBox},
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
