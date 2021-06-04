<template>
    <div class="check-image">
        <!--        <img :src="receipt" alt="">-->
        <viewer @inited="inited" ref="viewer">
            <template slot-scope="scope">
                <img :src="receipt" ref="viewerImage" alt="check" class="check">
            </template>
<!--            <img :src="receipt" ref="viewerImage" alt="check" class="check">-->
        </viewer>
        <zoom-on-hover ref="zoom" :img-normal="receipt" class="check-image__image"></zoom-on-hover>
        <div @click="rotate" class="check-rotate">
            <IconTurn/>
        </div>
        <!--        <div @mouseover="zoom()" @mousemove="move" @mouseout="reset" class="check-zoom" ref="coordinates"></div>-->
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
            x: 0,
            y: 0,
            rotation: 0,
        }),
        props: {
            receipt: null,
        },
        watch: {
            receipt: function (val) {
                if (document.querySelector(".viewer-move")) {
                    document.querySelector(".viewer-move").src = val;
                    this.$viewer.update();
                }
            }
        },
        methods: {
            clickViewer() {
                this.$refs.viewerImage.click();
            },
            inited(viewer) {
                this.$viewer = viewer
            },
            rotate() {
                this.rotation -= 90;
                if (this.rotation < -270) {
                    this.rotation = 0;
                }
                let normal = this.$refs.zoom.$el.querySelector('.normal');
                normal.style.transform = 'rotate(' + this.rotation + 'deg)';
                if (normal.getBoundingClientRect().width < 419) {
                    normal.style.transform = 'rotate(' + this.rotation + 'deg)' + 'scale(1.5)';
                }
                this.$refs.zoom.$el.querySelector('.zoom').style.transform = 'rotate(' + this.rotation + 'deg)';
            },
            move(event) {
                this.x = event.pageX - this.$refs.coordinates.getBoundingClientRect().left - 210;
                this.y = event.clientY - this.$refs.coordinates.getBoundingClientRect().top - 300;
                this.$viewer.move(-this.x * 0.05, -this.y * 0.05);
            },
        },
        mounted() {
            if (this.$refs.zoom) {
                this.$refs.zoom.$el.querySelector('.zoom').addEventListener('click', this.clickViewer);
            }
        },

        destroyed() {
            if (this.$refs.zoom) {
                this.$refs.zoom.$el.querySelector('.zoom').removeEventListener('click', this.clickViewer);
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
        box-shadow: 15px 15px 20px -5px rgba(217, 224, 235, .5);
        overflow: hidden;
        display: flex;
        align-items: center;

        .check {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
    }

    .check-rotate {
        position: absolute;
        bottom: 12px;
        right: 12px;
        cursor: pointer;
        z-index: 1;
    }

    .check-zoom {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }

    .viewer-canvas {
        .viewer-move {
            object-fit: contain !important;
        }
    }
</style>
