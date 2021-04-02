<template>
    <div class="check-image">
        <img :src="receipt" alt="">
        <div @click="showModal = true" class="check-zoom">
            <IconZoom/>
        </div>
        <Modal class="check-modal" v-if="showModal">
            <div class="icon text_pointer" @click="showModal = false">
                <IconCross i-color="white"/>
            </div>
            <img :src="receipt" alt="">
        </Modal>
    </div>

</template>

<script>
    import Modal from "@/components/modal/Modal";
    import IconCross from "@/assets/icons/IconCross";
    import IconZoom from "@/assets/icons/IconZoom";

    export default {
        name: "CheckImage",
        components: {IconZoom, IconCross, Modal},
        data: () => ({
            showModal: false,
        }),
        props: {
            receipt: null,
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
        box-shadow: 15px 15px 20px -5px rgba(217,224,235,.5);

        img {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
        }
    }

    .check-zoom {
        position: absolute;
        bottom: 12px;
        right: 12px;
        cursor: pointer;
    }
</style>
