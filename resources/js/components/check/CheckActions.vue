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
                <div @click="rejectModal = true" class="circle circle_lg check-action check-action_dislike">
                    <IconDislike/>
                    <p class="shortkey text_xs text_grey">Пробел</p>
                </div>
            </div>
            <div>
                <div @click.prevent="skipCurrentCheck" class="circle circle_lg check-action">
                    <IconSkip/>
                    <p class="shortkey text_xs text_grey">Tab</p>
                </div>
            </div>
            <div>
                <div @click="sendToApprove" class="circle circle_lg check-action check-action_like">
                    <IconLike/>
                    <p class="shortkey text_xs text_grey">Enter</p>
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
import CheckRejectForm from '@/components/check/CheckRejectForm';
import IconCross from '@/assets/icons/IconCross';
import IconSkip from '@/assets/icons/IconSkip';

export default {
    name: "CheckActions",
    components: {
        IconSkip,
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
            approve: 'checkActions/sendApprove',
            skipCheck: 'checkActions/skipCheck'
        }),
        sendToApprove() {
            this.approve();
        },

        skipCurrentCheck() {
            this.skipCheck()
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
    width: 204px;
}

.circle {
    position: relative;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.08), 0 2px 24px rgba(0, 0, 0, 0.08);
    background-color: white;
    width: 42px;
    cursor: pointer;
    height: 42px;
    transition: box-shadow ease 200ms;

    &:hover {
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.15), 0 2px 24px rgba(0, 0, 0, 0.15);
    }

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

