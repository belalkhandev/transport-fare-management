<script setup>
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import MonthlyBillCollectionChart from "@/Components/Charts/MonthlyBillCollectionChart.vue";
import {Link} from "@inertiajs/vue3";
import moment from "moment";
import PaymentStatusLabel from "@/Components/PaymentStatusLabel.vue";

const props = defineProps({
    total_students: {
        type: Number,
        default: 0
    },
    total_bills: {
        type: Number,
        default: 0
    },
    total_collections: {
        type: Number,
        default: 0
    },
    total_dues: {
        type: Number,
        default: 0
    },
    chart_data: {
        type: Object
    },
    latest_payments: {
        type: Object
    },
    data_month_year: {
        type: String
    }
});

</script>

<template>
    <AdminPanelLayout title="Dashboard">
        <template #header>Dashboard</template>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="dashboard-card card-1">
                    <i class='bx bx-radio-circle-marked'></i>
                    <div class="card-header">
                        <h5>Total Students</h5>
                    </div>
                    <div class="card-content">
                        <h2>{{ total_students }}</h2>
                        <Link :href="route('student.index')">View details <i class='bx bx-right-arrow-alt'></i></Link>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="dashboard-card card-2">
                    <i class='bx bx-radio-circle-marked'></i>
                    <div class="card-header">
                        <h5>Total Bill</h5>
                    </div>
                    <div class="card-content">
                        <h2>{{ total_bills }}</h2>
                        <Link :href="route('transport-bill.index')">View details <i class='bx bx-right-arrow-alt'></i></Link>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="dashboard-card card-3">
                    <i class='bx bx-radio-circle-marked'></i>
                    <div class="card-header">
                        <h5>Total Collection</h5>
                    </div>
                    <div class="card-content">
                        <h2>{{ total_collections }}</h2>
                        <Link :href="route('payment.index')">View details <i class='bx bx-right-arrow-alt'></i></Link>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="dashboard-card card-4">
                    <i class='bx bx-radio-circle-marked'></i>
                    <div class="card-header">
                        <h5>Total Due</h5>
                    </div>
                    <div class="card-content">
                        <h2>{{ total_dues }}</h2>
                        <Link :href="route('transport-bill.index')">View details <i class='bx bx-right-arrow-alt'></i></Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header no-border">
                Bill Collections
                <div class="action">
                    <span v-if="false" class="btn btn-sm py-0 px-1  btn-outline-secondary">
                        <i class="bx bx-chevron-left"></i>
                    </span>
                    <span class="mx-2">{{ data_month_year ?? moment().format('MMMM Y') }}</span>
                    <span v-if="false" class="btn btn-sm py-0 px-1 btn-outline-secondary">
                        <i class="bx bx-chevron-right"></i>
                    </span>
                </div>
            </div>
            <div class="box-body pb-4">
                <MonthlyBillCollectionChart :chart_data="chart_data"></MonthlyBillCollectionChart>
            </div>
            <div class="box-footer" v-if="false">
                <div class="cards">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">Total bills</div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ total_bills }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-success mb-3" style="max-width: 18rem;">
                                <div class="card-header">Collected</div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ total_bills }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-danger mb-3" style="max-width: 18rem;">
                                <div class="card-header">Due</div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ total_bills }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h5 class="title">Latest completed payments</h5>
                <div class="box-action">
                    <Link :href="route('payment.index')" class="btn btn-sm btn-primary">View All</Link>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Trans No/Paid at</th>
                        <th>Student</th>
                        <th>Amount</th>
                        <th>Payment ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(payment, i) in latest_payments">
                        <td>
                            {{ payment.trans_id }}
                            <p>{{ moment(payment.transaction_date).format('LL') }}</p>
                        </td>
                        <td>
                            <Link :href="route('student.show', payment.transport_bill.student.id)">{{ payment.transport_bill.student.student_id }}</Link>
                            <p class="m-0 p-0">
                                {{ payment.transport_bill.student.name }}
                            </p>
                        </td>
                        <td>
                            {{ payment.amount }}
                            <p>{{ payment.gateway }}</p>
                        </td>
                        <td>{{ payment.gateway_trans_id }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </AdminPanelLayout>
</template>
