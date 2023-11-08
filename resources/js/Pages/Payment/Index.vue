<script setup>
import PaymentPanelLayout from "@/Layouts/PaymentPanelLayout.vue";
import {useForm} from "@inertiajs/vue3";
import moment from "moment";

const props = defineProps({
    student: {
        type: Object
    },
    unpaid_bill: {
        type: Object
    },
    transportBills: {
        type: Object
    },
    total_bill_amount: {
        type: Number
    },
    total_paid_amount: {
        type: Number
    },
    total_due_amount: {
        type: Number
    },
    penalty_on_due: {
        type: Number
    }
})

const form = useForm({
    trans_id: props.unpaid_bill ? props.unpaid_bill.payment.trans_id : '',
    amount: props.unpaid_bill ? props.unpaid_bill.payment.amount : ''
})
const createBkashPayment = () => {
    form.post(route('create.payment'), {
        preserveScroll: true,
    })
}

const payNow = (bill) => {
    form.trans_id = bill.payment.trans_id;
    form.amount = bill.payment.amount

    createBkashPayment();
}

</script>

<template>
    <PaymentPanelLayout :student="student" :title="'Payment Portal'">
        <section v-if="unpaid_bill" class="bill-payment">
            <div class="row">
                <div class="col-md-8">
                    <h4>Payment Invoice: {{ unpaid_bill.payment.trans_id }}</h4>
                    <div class="payment-items">
                        <div class="item">
                            <span>Payment For</span>
                            <h5>{{ unpaid_bill.formatted_month_year }}</h5>
                        </div>
                        <div class="item">
                            <span>Amount</span>
                            <h5>{{ unpaid_bill.amount }}</h5>
                        </div>
                        <div v-if="unpaid_bill.due_amount" class="item">
                            <span>Due Amount</span>
                            <h5>{{ unpaid_bill.due_amount }}</h5>
                        </div>
                        <div class="item">
                            <span>Due Date</span>
                            <h5>{{ moment(unpaid_bill.due_date).format('DD MMM Y') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="payment">
                        <h3 class="text-right"><span>Total:</span> {{ unpaid_bill.payment.amount }}</h3>
                        <div class="payment-gateway">
                            <span>Pay now</span>
                            <form @submit.prevent="createBkashPayment"  method="POST">
                                <button type="submit" id="bKashButton" :disabled="form.processing" class="button">
                                    <img src="@/assets/images/bkash-wh.svg" alt="">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-sm text-danger mt-4">A penalty of {{ penalty_on_due }} TK will be applicable for payments made after the due date.</p>
        </section>
        <section class="cards">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-body">
                            <span class="label">Total Bill Amount</span>
                            <h3>{{ total_bill_amount }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-success">
                        <div class="card-body">
                            <span class="label">Total Paid Amount</span>
                            <h3>{{ total_paid_amount }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-warning">
                        <div class="card-body">
                            <span class="label">Total Due Amount</span>
                            <h3>{{ total_due_amount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bills">
            <h3 class="title">Payment History</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Trans ID</th>
                    <th>Bill Month</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Gateway</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="bill in transportBills">
                    <td>
                        <span>{{ moment(bill.created_at).format('DD MMM, Y') }}</span>
                        <p>{{ bill.payment.trans_id }}</p>
                    </td>
                    <td>
                        {{ bill.formatted_month_year }}
                    </td>
                    <td>
                        {{ bill.payment.amount }}
                    </td>
                    <td>
                        <span v-if="bill.payment.transaction_date">{{ moment(bill.payment.transaction_date).format('DD MMM, Y') }}</span>
                        <p>{{ bill.payment.gateway_trans_id }}</p>
                    </td>
                    <td>
                        <span v-if="bill.is_paid === 1">{{ bill.payment.gateway.toUpperCase() }}</span>
                        <span v-else>-</span>
                    </td>
                    <td class="text-right">
                        <button v-if="bill.is_paid == 0" class="btn btn-sm btn-payment" @click="payNow(bill)">Pay now</button>
                        <button v-else class="btn btn-sm btn-success">Paid</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
    </PaymentPanelLayout>
</template>

<style scoped>

</style>
