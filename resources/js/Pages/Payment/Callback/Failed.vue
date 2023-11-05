<script setup>
import {Link} from "@inertiajs/vue3";
import StudentProfile from "@/Components/StudentProfile.vue";
import PaymentPanelLayout from "@/Layouts/PaymentPanelLayout.vue";
const props = defineProps({
    transport_bill: {
        type: Object,
    },
    student: {
        type: Object,
    },
    status_message: {
        type: String
    }
});
</script>

<template>
    <PaymentPanelLayout :student="student" :title="'Cancelled'">
        <div class="payment-status-box text-center">
            <img src="../../../assets/images/payment-failed.png" alt="">
            <h2 class="text-danger">{{ status_message ?? 'Payment failed' }}</h2>
            <p>We apologize, but there was an issue processing your payment for this stage. It seems you have already made a payment for this stage. If you have any concerns or need clarification, please reach out to our customer support for assistance. Your satisfaction is important to us.</p>
            <Link :href="route('transport-payment.student', student.student_id)" class="btn btn-outline-primary mt-4">Try Again</Link>
        </div>
    </PaymentPanelLayout>
</template>

<style scoped>

</style>
