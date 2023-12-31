<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import NavLink from "../../Components/NavLink.vue";
import Pagination from "../../Components/Pagination.vue";
import ActiveStatusLabel from "@/Components/ActiveStatusLabel.vue";


const props = defineProps({
    students: {
        type: Object,
        default: () => ({})
    },
    filterData: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({});

const deleteAction = (student_id) => {
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
            form.delete(route('student.delete', student_id), {
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: "Academic plan has been deleted successfully"
                    });
                }
            })
        }
    })
}

const filteringForm = useForm({
    search: props.filterData.search ? props.filterData.search : ''
});

const submitForm = () => {
    filteringForm.get(route('student.index'), {
        preserveScroll: true,
    })
}

</script>

<template>
    <Head title="Student" />
    <AdminPanelLayout>
        <template #header>Student list</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Student list</h5>
                <div class="action">
                    <NavLink :href="route('student.create')" class="btn btn-sm btn-outline-primary">Add new</NavLink>
                </div>
            </div>
            <div class="box-filter pt-2">
                <form @submit.prevent="submitForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" v-model="filteringForm.search" class="form-control" placeholder="Name, student id, contact no">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                            <Link :href="route('student.index')" class="ml-2 btn btn-outline-warning">Reset</Link>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Parents</th>
                            <th>Contact</th>
                            <th>Area - Fee</th>
                            <th>Academic Plan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(student, i) in students.data">
                            <td>
                                <Link :href="route('student.show', student.id)">{{ student.student_id }}</Link>
                                <p>{{ student.name }}</p>
                            </td>
                            <td>
                                <p><i class='bx bx-male text-violet-300'></i> {{ student.father_name }}</p>
                                <p><i class='bx bx-female text-purple-300'></i> {{ student.mother_name }}</p>
                            </td>
                            <td>{{ student.contact_no }}</td>
                            <td>{{ student.transport_fee ? student.transport_fee.fee.area.name + ' - ' +student.transport_fee.fee.amount : '' }}</td>
                            <td>
                                {{ student.academic_plans[0] ? student.academic_plans[0].name : '' }}</td>
                            <td>
                                <ActiveStatusLabel :status="student.is_active"/>
                            </td>
                            <td>
                                <div class="action">
                                    <ul>
                                        <li>
                                            <Link :href="route('student.edit', student.id)" class="btn btn-sm btn-rounded btn-outline-primary"><i class="bx bx-edit"></i></Link>
                                        </li>
                                        <li>
                                            <button @click="deleteAction(student.id)" class="btn btn-sm btn-rounded btn-outline-danger"><i class="bx bx-trash"></i></button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <Pagination :data="students"/>
            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
