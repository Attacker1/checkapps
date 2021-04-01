<template>
    <div @click="rejectModal = true">
        <IconDislike/>
    </div>
</template>

<script>
import Modal from "@/components/modal/Modal";
import IconDislike from "@/assets/icons/IconDislike";
import FormRadio from "@/components//form/FormRadio";
import CheckRejectForm from "@/components/check/CheckRejectForm";
import IconCross from '@/assets/icons/IconCross';

export default {
    name: "CheckReject",
    components: {IconCross, CheckRejectForm, FormRadio, IconDislike, Modal},
    data: () => ({
        rejectModal: false,
    }),
}
</script>

