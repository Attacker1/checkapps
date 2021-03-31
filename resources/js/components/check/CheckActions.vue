<template>
    <div class="d-flex justify-center pa-20 mb-25">
        <div class="check-actions">
            <Modal v-if="modal"/>
            <div>
                <div class="circle check-navigation check-navigation_left">
                    <IconArrowLeft/>
                    <IconArrowLeftSm class="shortkey shortkey_nav"/>
                </div>
            </div>
            <div>
                <div class="circle circle_lg check-action check-action_dislike">
                    <div @click><IconDislike/></div>
                    <p class="shortkey text_xs text_grey">Пробел</p>
                </div>
            </div>
            <div>
                <div class="circle circle_lg check-action check-action_like">
                    <IconLike/>
                    <p class="shortkey text_xs text_grey">Enter</p>
                </div>
            </div>
            <div>
                <div class="circle check-navigation check-navigation_right">
                    <IconArrowRight/>
                    <IconArrowRightSm class="shortkey shortkey_nav"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import IconArrowLeft from '@/assets/icons/IconArrowLeft.vue';
    import IconArrowRight from '@/assets/icons/IconArrowRight.vue';
    import IconLike from '@/assets/icons/IconLike.vue';
    import IconDislike from '@/assets/icons/IconDislike.vue';
    import IconArrowLeftSm from '@/assets/icons/IconArrowLeftSm.vue';
    import IconArrowRightSm from '@/assets/icons/IconArrowRightSm.vue';
    import Modal from "@/components/modal/Modal";

    export default {
        name: "CheckActions",
        components: {Modal, IconArrowRightSm, IconArrowLeftSm, IconDislike, IconLike, IconArrowRight, IconArrowLeft},
        data: () => ({
            modal: false,
        })
    }
</script>

<style lang="scss" scoped>
    .check-actions,
    .check-tooltips {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 252px;
    }

    .circle {
        position: relative;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
        background-color: white;
        width: 42px;
        cursor: pointer;
        height: 42px;

        &_lg {
            width: 52.5px;
            height: 52.5px;
        }
    }

    .shortkey {
        position: absolute;
        top: calc(100% + 10px);

        &_nav {
            top: calc(100% + 16px);
        }
    }
</style>
