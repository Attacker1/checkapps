<template>
    <div class="check-image">
<!--        <img :src="receipt" alt="">-->
        <croppa v-model="myCroppa"
                width="450"
                height="600"
                :disable-click-to-choose="true"
                :disable-rotation="false"
                :show-remove-button="false"
        >
            <img :src="receipt" slot="initial">
        </croppa>
        <div  @click.prevent="myCroppa.rotate()" class="check-zoom">
            <IconTurn/>
        </div>
        <!--<Modal class="check-modal" v-if="showModal">
            <div class="icon text_pointer" @click="showModal = false">
                <IconCross i-color="white"/>
            </div>
            <img :src="receipt" alt="">
        </Modal>-->
    </div>
</template>

<script>
    import Modal from "@/components/modal/Modal";
    import IconCross from "@/assets/icons/IconCross";
    import IconTurn from "@/assets/icons/IconTurn";



    export default {
        name: "CheckImage",
        components: {IconTurn, IconCross, Modal},
        data: () => ({
            showModal: false,
            myCroppa: {},
        }),
        props: {
            receipt: null,
        },
        methods: {
            rotateImage() {
                this.myCroppa.rotate();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .check-modal {
        .icon {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 999;
            width: 30px;
            height: 30px;

            svg {
                width: 100%;
                height: 100%;
            }
        }
    }

    .check-image {
        border: 0.5px solid rgba(0, 0, 0, 0.08);
        box-sizing: border-box;
        border-radius: 6px;
        position: relative;
        background-color: $bg_dark;

        &__zoom {
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            overflow: hidden;
        }

        .vh--message {
            display: none !important;
        }
    }

    .check-zoom {
        position: absolute;
        bottom: 12px;
        right: 12px;
        cursor: pointer;
    }
</style>
