<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import ActiveStatusLabel from "@/Components/ActiveStatusLabel.vue";
import PaymentStatusLabel from "@/Components/PaymentStatusLabel.vue";
import moment from "moment";

const props = defineProps({
    payments: {
        type: Object,
        default: () => ({})
    }
});

</script>

<template>
    <Head title="Transport payments" />
    <AdminPanelLayout>
        <template #header>Transport payments</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Transport payments</h5>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Trans No</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Gateway</th>
                            <th>Gateway Trans. ID</th>
                            <th>Paid at</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(payment, i) in payments.data">
                            <td>{{ payment.trans_id }}</td>
                            <td>
                                <Link :href="route('student.show', payment.transport_bill.student.id)">{{ payment.transport_bill.student.student_id }}</Link>
                                <p class="m-0 p-0">
                                    {{ payment.transport_bill.student.name }}
                                </p>
                            </td>
                            <td>{{ payment.amount }}</td>
                            <td>{{ payment.gateway }}</td>
                            <td>{{ payment.gateway_trans_id }}</td>
                            <td>{{ moment(payment.transaction_date).format('LL') }}</td>
                            <td><PaymentStatusLabel :status="payment.status"/></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <Pagination :data="payments"/>
            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
