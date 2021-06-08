<template>
    <div class="d-flex justify-center pa-20 mb-25"
         v-shortkey.once="['esc']"
         @shortkey="closeRejectModal()"
    >
        <Modal class="reject-modal" :class="{active: rejectModal}" v-if="isMobile() ? rejectModal : true"
               @close="rejectModal = false"
        >
            <div class="container">
                <div class="reject-modal__close">
                    <div @click="closeRejectModalForce">
                        <IconCross/>
                    </div>
                </div>
                <CheckRejectForm @inputText="inputText" @closeRejectForm="rejectModal = false"/>
            </div>
        </Modal>

        <div class="check-actions">
            <div>
                <div @click="clickRejected"
                     class="circle circle_lg check-action check-action_dislike"
                     v-shortkey.once="['arrowleft', 'shift']"
                     @shortkey="clickRejected()"
                >
                    <IconDislike/>
                    <p class="shortkey text_sm text_grey">Shift + ←</p>
                </div>
            </div>
            <div>
                <div @click.prevent="skipCurrentCheck" class="circle circle_lg check-action"
                     v-shortkey="['tab']" @shortkey="skipCurrentCheck()">
                    <IconSkip/>
                    <p class="shortkey text_sm text_grey">Tab</p>
                </div>
            </div>
            <div>
                <div @click="sendToApprove" class="circle circle_lg check-action check-action_like"
                     v-shortkey="['arrowright', 'shift']" @shortkey="sendToApprove()">
                    <IconLike/>
                    <p class="shortkey text_sm text_grey">Shift + →</p>
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
    import {mapActions, mapState, mapGetters} from 'vuex';
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
            lock: false,
        }),
        /*created() {
            const component = this;
            this.handler = function (e) {
                e.keyCode === 9 && component.$refs.skipButton.click()
                e.keyCode === 32 && component.changeRejectedModal()
                e.keyCode === 13 && component.$refs.approveButton.click()
            }
            document.addEventListener('keydown', this.handler);
        },

        beforeDestroy() {
            window.removeEventListener('keyup', this.handler);
        },*/
        methods: {
            ...mapActions({
                approve: 'checkActions/sendApprove',
                skipCheck: 'checkActions/skipCheck',
                check: 'currentCheck/currentCheck',
            }),

            inputText(val) {
                this.lock = val;
            },

            sendToApprove() {
                if (!this.rejectModal) {
                    this.approve();
                }
            },

            skipCurrentCheck() {
                if (!this.rejectModal) {
                    this.skipCheck();
                }
            },

            clickRejected() {
                this.rejectModal = true;
            },

            closeRejectModal() {
                if (!this.lock) {
                    this.rejectModal = false;
                }
            },

            closeRejectModalForce() {
                this.rejectModal = false;
                this.lock = false;
            },

            isMobile() {
                return this.windowSize < 1023;
            },
        },
        computed: {
            // ...mapState('common', ['windowSize']),
            ...mapGetters({
                windowSize: 'common/windowSize',
                countChecks: 'checkActions/countChecks'
            })
        },

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

    .reject-modal {
        &__close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;

            @media screen and (max-width: 1023px) {
                position: unset;
                display: flex;
                justify-content: flex-end;
            }

            svg {
                fill: #000;

                @media screen and (max-width: 1023px) {
                    fill: #fff;
                }
            }
        }
    }
</style>

