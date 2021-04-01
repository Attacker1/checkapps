<template>
    <div class="d-flex justify-center pa-20 mb-25">
        <Modal class="reject-modal" v-if="rejectModal" @close="rejectModal = false">
            <div class="container">
                <div class="d-flex justify-end mb-5">
                    <div @click="rejectModal = false">
                        <IconCross i-color="white"/>
                    </div>
                </div>
                <CheckRejectForm @closeRejectForm="rejectModal = false"/>
            </div>
        </Modal>

        <div class="check-actions">
            <div>
                <div @click="prevCheck" class="circle check-navigation check-navigation_left">
                    <IconArrowLeft/>
                    <IconArrowLeftSm class="shortkey shortkey_nav"/>
                </div>
            </div>
            <div>
                <div @click="rejectModal = true" class="circle circle_lg check-action check-action_dislike">
                    <IconDislike/>
                    <p class="shortkey text_xs text_grey">Пробел</p>
                </div>
            </div>
            <div>
                <div @click="sendToApprove" class="circle circle_lg check-action check-action_like">
                    <IconLike/>
                    <p class="shortkey text_xs text_grey">Enter</p>
                </div>
            </div>
            <div>
                <div @click="nextCheck" class="circle check-navigation check-navigation_right">
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
import CheckReject from "@/components/check/CheckReject";
import {mapActions} from 'vuex';
import CheckRejectForm from './CheckRejectForm';
import IconCross from '../../assets/icons/IconCross';

export default {
    name: "CheckActions",
    components: {
        IconCross,
        CheckRejectForm,
        CheckReject,
        Modal, IconArrowRightSm, IconArrowLeftSm, IconDislike, IconLike, IconArrowRight, IconArrowLeft
    },
    data: () => ({
        rejectModal: false,
    }),
    methods: {
        ...mapActions({
            approve: 'check/sendApprove',
            nextPrev: 'check/fetchCheckItem'
        }),
        sendToApprove() {
            this.approve();
        },
        nextCheck() {
            this.nextPrev()
        },
        prevCheck() {
            this.nextPrev()
        }
    }
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

.reject-form {
    width: 100%;
    margin: auto;
}
</style>

