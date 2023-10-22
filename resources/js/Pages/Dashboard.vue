<script setup>
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import MonthlyBillCollectionChart from "@/Components/Charts/MonthlyBillCollectionChart.vue";
import {Link} from "@inertiajs/vue3";

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
                        <Link :href="route('student.index')">View details <i class='bx bx-right-arrow-alt'></i></Link>
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
                        <Link :href="route('student.index')">View details <i class='bx bx-right-arrow-alt'></i></Link>
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
                        <Link :href="route('student.index')">View details <i class='bx bx-right-arrow-alt'></i></Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header no-border">
                Bill Collections
                <div class="action">October - 2023</div>
            </div>
            <div class="box-body pb-4">
                <MonthlyBillCollectionChart/>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h5 class="title">Latest 10 transactions</h5>
                <div class="box-action">
                    <Link :href="route('student.index')" class="btn btn-sm btn-primary">View All</Link>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Transaction No</th>
                        <th>Student</th>
                        <th>Month/Year</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Paid At</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </AdminPanelLayout>
</template>
