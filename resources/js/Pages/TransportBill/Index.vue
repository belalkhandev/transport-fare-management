<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import ActiveStatusLabel from "@/Components/ActiveStatusLabel.vue";
import PaymentStatusLabel from "@/Components/PaymentStatusLabel.vue";
import RefundStatusLabel from "@/Components/RefundStatusLabel.vue";
import moment from "moment";

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
    payment_status: props.filterData.payment_status ? props.filterData.payment_status : '',
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" v-model="filteringForm.search" class="form-control" placeholder="Search key">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group d-flex">
                                <select v-model="filteringForm.payment_status" class="mr-2 form-select">
                                    <option value="">Status</option>
                                    <option value="paid">Paid</option>
                                    <option value="unpaid">Unpaid</option>
                                </select>
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
                            <Link :href="route('transport-bill.index')" class="btn btn-outline-warning">Reset</Link>
                            <button type="submit" class="ml-2 btn btn-outline-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Trans. No</th>
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
                            <td>
                                {{ moment(bill.created_at).format('DD MMM, Y') }}
                                <p class="text-black">
                                    {{ bill.payment.trans_id }}
                                </p>
                            </td>
                            <td>
                                <Link :href="route('student.show', bill.student.id)">{{ bill.student.student_id }}</Link>
                                <p class="m-0 p-0">
                                    {{ bill.student.name }}
                                </p>
                            </td>
                            <td>{{ bill.formatted_month_year }}</td>
                            <td>{{ bill.amount }}</td>
                            <td>{{ moment(bill.due_date).format('DD MMM, Y') }}</td>
                            <td>
                                <PaymentStatusLabel :status="bill.payment.status"/>
                            </td>
                            <td>
                                <button  v-if="bill.payment.refund && bill.payment.refund.status === 'refunded'" class="btn btn-sm btn-outline-success">Refunded</button>
                                <Link  v-else-if="bill.payment.status === 'completed'" :href="route('payment.refund', bill.payment.trans_id)" class="btn btn-sm btn-outline-danger">Refund</Link>
                            </td>
                            <td>
                                <div class="action">
                                    <ul>
                                        <li>
                                            <Link v-if="bill.payment.status === 'pending'" :href="route('transport-bill.payment-manually', bill.payment.trans_id)" class="btn btn-sm btn-rounded btn-hand-money btn-outline-warning">
                                                <img src="@/assets/images/icons/hand-money.svg" alt="">
                                            </Link>
                                        </li>
                                        <li>
                                            <Link v-if="bill.payment.status === 'pending'"  :href="route('transport-bill.edit', bill.id)" class="btn btn-sm btn-rounded btn-outline-primary"><i class="bx bx-edit"></i></Link>
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
