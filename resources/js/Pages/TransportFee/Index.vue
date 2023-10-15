<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import ActiveStatusLabel from "@/Components/ActiveStatusLabel.vue";

const props = defineProps({
    transport_fees: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({});

const deleteAction = (transport_fee_id) => {
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
            form.delete(route('transport-fee.delete', transport_fee_id), {
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

</script>

<template>
    <Head title="Transport fee" />
    <AdminPanelLayout>
        <template #header>Transport fee</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Transport fee</h5>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Area</th>
                            <th>Amount</th>
                            <th>Discounted Amount</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(transport_fee, i) in transport_fees.data">
                            <td>{{ transport_fees.from + i }}</td>
                            <td>
                                <Link :href="route('student.show', transport_fee.student.id)">{{ transport_fee.student.student_id }}</Link>
                                <p class="m-0 p-0">
                                    {{ transport_fee.student.name }}
                                </p>
                            </td>
                            <td>{{ transport_fee.fee.area.name }}</td>
                            <td>{{ transport_fee.fee.amount }}</td>
                            <td>{{ transport_fee.discounted_amount }}</td>
                            <td>
                                <ActiveStatusLabel :status=transport_fee.student.is_active />
                            </td>
                            <td>{{ transport_fee.remarks }}</td>
                            <td>
                                <div class="action">
                                    <ul>
                                        <li>
                                            <Link :href="route('transport-fee.edit', transport_fee.id)" class="btn btn-sm btn-rounded btn-outline-primary"><i class="bx bx-edit"></i></Link>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <Pagination :data="transport_fees"/>
            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
