<script setup>
import {Link, useForm} from "@inertiajs/vue3";
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
        <div class="payment-status-box">
            <img src="../../../assets/images/payment-success.png" alt="">
            <h2 class="text-success">Payment Already Completed</h2>
            <p>This stage has been successfully completed. We acknowledge your progress and thank you for your dedication. If you have any further steps or inquiries, please feel free to reach out.</p>
            <Link class="btn btn-outline-primary" :href="route('transport-payment.student', student.student_id)">View Bill History</Link>
        </div>
    </PaymentPanelLayout>
</template>

<style scoped>

</style>
