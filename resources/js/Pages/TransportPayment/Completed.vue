<script setup>
import {useForm} from "@inertiajs/vue3";
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
                            <img src="@/assets/images/payment-success.png" alt="">
                            <h2 class="text-success">Payment Already Completed</h2>
                            <p>This stage has been successfully completed. We acknowledge your progress and thank you for your dedication. If you have any further steps or inquiries, please feel free to reach out.</p>
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
