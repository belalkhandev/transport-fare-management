<script setup>
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    transport_bill_id: {
        type: String,
    }
});

const form = useForm({
    transport_bill_id: props.transport_bill_id
})
const submitForm = () => {
    Swal.fire(
        'Not acceptable',
        'No payment method is available right now',
        'warning'
    )
}


</script>

<template>
    <div class="row">
        <div class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-6 offset-md-3">
            <div class="payment-box">
                <div class="payment-box-header">
                    <img src="@/assets/images/bafsk-logo.png" alt="">
                    <div class="text-right">
                        <h3 class="text-center">BAFSK BUS Payment</h3>
                        <h5>Payment ID: {{ transport_bill_id }}</h5>
                    </div>
                </div>
                <div class="payment-box-content">
                    <h5 class="title">Student Information</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td>Student ID</td>
                            <th>123456</th>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <th>Md. Bellal Hossain</th>
                        </tr>
                        <tr>
                            <td>Academic Status</td>
                            <td>Class 9, Session: 2023-24, Section: B</td>
                        </tr>
                    </table>
                    <div class="payment-info pt-2">
                        <h5 class="title">Transport Payment</h5>
                        <div class="d-flex justify-between">
                            <h4>Month: <span>October - 2023</span></h4>
                            <h4>Amount: <span>1500 BDT</span></h4>
                        </div>
                        <h6>Pay with</h6>
                        <form @submit.prevent="submitForm"  method="POST">
                            <button type="submit" id="bKashButton" class="button">
                                <img src="@/assets/images/bkash.svg" alt="">
                            </button>
                        </form>
                    </div>
                </div>
                <div class="payment-box-footer pt-4">
                    <div class="text-center">
                        <p>Developed By <a href="http://ideasolutionbd.com/">Idea solutionsBd</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
