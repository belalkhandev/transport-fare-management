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
});
</script>

<template>
    <PaymentPanelLayout :student="student" :title="'Cancelled'">
        <div class="payment-status-box text-center">
            <img src="../../../assets/images/payment-failed.png" alt="">
            <h2 class="text-warning">Payment Canceled</h2>
            <p class="text-muted">We regret to inform you that your payment for this stage has been canceled. If you require further assistance or have any questions, please do not hesitate to contact our customer support team.</p>
            <Link :href="route('transport-payment.student', student.student_id)" class="btn btn-outline-primary mt-4">Try Again</Link>
        </div>
    </PaymentPanelLayout>
</template>

<style scoped>

</style>
