<template>
    <div>
        <Modal class="reject-modal" v-if="rejectModal" @close="rejectModal = false">
            <div class="container">
                <CheckRejectForm @closeRejectForm="rejectModal = false"/>
            </div>
        </Modal>
        <div @click="rejectModal = true">
            <IconDislike/>
        </div>
    </div>
</template>

<script>
    import Modal from "@/components/modal/Modal";
    import IconDislike from "@/assets/icons/IconDislike";
    import FormRadio from "@/components//form/FormRadio";
    import CheckRejectForm from "@/components/check/CheckRejectForm";

    export default {
        name: "CheckReject",
        components: {CheckRejectForm, FormRadio, IconDislike, Modal},
        data: () => ({
            rejectModal: false,
            toggle: false,
            textarea: false,
        }),
    }
</script>

<style lang="scss" scoped>
    .reject-form {
        width: 100%;
        margin: auto;
    }
</style>
