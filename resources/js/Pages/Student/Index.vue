<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import NavLink from "../../Components/NavLink.vue";
import Pagination from "../../Components/Pagination.vue";

const props = defineProps({
    students: {
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
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Father name</th>
                            <th>Mother name</th>
                            <th>Contact</th>
                            <th>Academic</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(student, i) in students.data">
                            <td>
                                <Link :href="route('student.show', student.id)">{{ student.student_id }}</Link>
                            </td>
                            <td>{{ student.name }}</td>
                            <td>{{ student.father_name }}</td>
                            <td>{{ student.mother_name }}</td>
                            <td>{{ student.contact_no }}</td>
                            <td>{{ student.academic_plans[0] ? student.academic_plans[0].name : '' }}</td>
                            <td>
                                <span v-if="student.is_active" class="badge bg-success">Active</span>
                                <span v-else class="badge bg-danger">Inactive</span>
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
