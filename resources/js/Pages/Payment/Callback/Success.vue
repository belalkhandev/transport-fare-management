<script setup>
import PaymentPanelLayout from "@/Layouts/PaymentPanelLayout.vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    transport_bill: {
        type: Object,
    },
    student: {
        type: Object,
    },
});
</script>

<template>
    <PaymentPanelLayout :student="student" :title="'Payment Success'">
        <div class="payment-status-box payment-success text-center">
            <img src="../../../assets/images/payment-success.png" alt="">
            <h2 class="text-success">Payment Success</h2>
            <p>We are pleased to inform you that your payment has been processed successfully. We extend our sincere gratitude for your payment and for selecting our services. Your continued support is greatly appreciated.</p>
            <Link class="btn btn-outline-primary" :href="route('transport-payment.student', student.student_id)">View Bill History</Link>
        </div>
    </PaymentPanelLayout>
</template>

<style scoped>

</style>
