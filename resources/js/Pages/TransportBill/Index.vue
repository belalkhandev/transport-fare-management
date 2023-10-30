<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import ActiveStatusLabel from "@/Components/ActiveStatusLabel.vue";
import PaymentStatusLabel from "@/Components/PaymentStatusLabel.vue";

const props = defineProps({
    bills: {
        type: Object,
        default: () => ({})
    },
    months: {
        type: Object
    },
    years: {
        type: Object
    },
    filterData: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({});

const deleteAction = (bill_id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0284c7',
        cancelButtonColor: '#DC2626',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('transport-bill.delete', bill_id), {
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: "Transport fee has been deleted successfully"
                    });
                }
            })

        }
    })
}

const filteringForm = useForm({
    search: props.filterData.search ? props.filterData.search : '',
    month: props.filterData.month ? props.filterData.month : '',
    year: props.filterData.year ? props.filterData.year : '',
});

const submitSearchForm = () => {
    filteringForm.get(route('transport-bill.index'), {
        preserveScroll: true,
    })
}

</script>

<template>
    <Head title="Transport bills" />
    <AdminPanelLayout>
        <template #header>Transport bills</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Transport bills</h5>
            </div>
            <div class="box-filter pt-2">
                <form @submit.prevent="submitSearchForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" v-model="filteringForm.search" class="form-control" placeholder="Contact no, Transaction ID">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group d-flex">
                                <select v-model="filteringForm.month" id="monthYear" class="mr-2 form-select">
                                    <option value="">All Month</option>
                                    <option v-for="month in months" :value=month.value>{{ month.name }}</option>
                                </select>
                                <select v-model="filteringForm.year" id="monthYear" class="ml-2 form-select">
                                    <option value="">All Year</option>
                                    <option v-for="year in years" :value=year.value>{{ year.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                            <Link :href="route('transport-bill.index')" class="ml-2 btn btn-outline-warning">Reset</Link>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Trans No</th>
                            <th>Student</th>
                            <th>Month-Year</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Refund</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(bill, i) in bills.data">
                            <td>{{ bill.payment.trans_id }}</td>
                            <td>
                                <Link :href="route('student.show', bill.student.id)">{{ bill.student.student_id }}</Link>
                                <p class="m-0 p-0">
                                    {{ bill.student.name }}
                                </p>
                            </td>
                            <td>{{ bill.formatted_month_year }}</td>
                            <td>{{ bill.amount }}</td>
                            <td>{{ bill.due_date }}</td>
                            <td><PaymentStatusLabel :status="bill.payment.status"/></td>
                            <td>
                                <Link :href="route('transport-bill.edit', bill.id)" class="btn btn-sm btn-outline-warning">Refund</Link>
                            </td>
                            <td>
                                <div class="action">
                                    <ul>
                                        <li>
                                            <Link :href="route('transport-bill.edit', bill.id)" class="btn btn-sm btn-rounded btn-outline-primary"><i class="bx bx-edit"></i></Link>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <Pagination :data="bills"/>
            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
