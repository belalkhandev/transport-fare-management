<script setup>
import {Link} from "@inertiajs/vue3";
import StudentProfile from "@/Components/StudentProfile.vue";
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="payment-box">
                    <div class="payment-box-header">
                        <img src="@/assets/images/bafsk-logo.png" alt="">
                        <div class="text-right">
                            <h3 class="text-center">BAFSK-Bus Payment</h3>
                        </div>
                    </div>
                    <div class="payment-box-content">
                        <StudentProfile :student="student"></StudentProfile>

                        <div class="payment-status text-center">
                            <img src="@/assets/images/payment-failed.png" alt="">
                            <h2 class="text-success">Payment Failed</h2>
                            <p>We apologize, but there was an issue processing your payment for this stage. It seems you have already made a payment for this stage. If you have any concerns or need clarification, please reach out to our customer support for assistance. Your satisfaction is important to us.</p>
                            <Link :href="route('transport-bill.user.payment', transport_bill.payment.trans_id)" class="btn btn-sm btn-primary mt-4">Try Again</Link>
                        </div>
                    </div>
                    <div class="payment-box-footer pt-4">
                        <div class="text-center">
                            <p>Developed By <a href="https://ideasolutionbd.com/">Idea Solution</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
