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
    due_amount: {
        type: Number
    }
});

const form = useForm({
    trans_id: props.transport_bill.payment.trans_id,
    amount: props.transport_bill.payment.amount
})
const createBkashPayment = () => {
    form.post(route('create.payment'), {
        preserveScroll: true,
    })
}
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
                        <div class="invoice-summary" v-if="transport_bill.payment.status === 'pending'">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>Payment Invoice: {{ transport_bill.payment.trans_id }}</h4>
                                    <div class="invoice-summary-items">
                                        <div class="item">
                                            <span>Payment For</span>
                                            <h5>{{ transport_bill.formatted_month_year }}</h5>
                                        </div>
                                        <div class="item">
                                            <span>Amount</span>
                                            <h5>{{ transport_bill.amount }}</h5>
                                        </div>
                                        <div v-if="transport_bill.due_amount" class="item">
                                            <span>Due Amount</span>
                                            <h5>{{ transport_bill.due_amount  }}</h5>
                                        </div>
                                        <div class="item">
                                            <span>Due Date</span>
                                            <h5>{{ transport_bill.due_date }}</h5>
                                        </div>
                                    </div>
                                    <p class="text-sm text-danger-emphasis mt-4">A penalty of {{ due_amount }} TK will be applicable for payments made after the due date.</p>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="text-right">Total: {{ transport_bill.payment.amount }}</h4>
                                    <div class="gateway">
                                        <span>Pay now</span>
                                        <form @submit.prevent="createBkashPayment"  method="POST">
                                            <button type="submit" id="bKashButton" :disabled="form.processing" class="button">
                                                <img src="@/assets/images/bkash.svg" alt="">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        <div class="payment-list">
                            <h3>Billing History</h3>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Trans ID</th>
                                    <th>Date</th>
                                    <th>Payment ID</th>
                                    <th>Amount</th>
                                    <th>Paid at</th>
                                </tr>
                                </thead>
                            </table>
                        </div>-->
                    </div>
                    <div class="payment-box-footer pt-4">
                        <div class="text-center">
                            <p>Developed By <a href="http://ideasolutionbd.com/">Idea solutionsBd</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
