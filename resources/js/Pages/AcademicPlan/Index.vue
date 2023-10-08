<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import NavLink from "../../Components/NavLink.vue";
import Pagination from "../../Components/Pagination.vue";

const props = defineProps({
    academic_plans: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({});

const deleteAction = (academic_plan_id) => {
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
            form.delete(route('academic-plan.delete', academic_plan_id), {
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
    <Head title="Academic plan" />
    <AdminPanelLayout>
        <template #header>Academic Plans</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Academic Plans</h5>
                <div class="action">
                    <NavLink :href="route('academic-plan.create')" class="btn btn-sm btn-outline-primary">Create new</NavLink>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Year</th>
                            <th>Version</th>
                            <th>Class</th>
                            <th>Group</th>
                            <th>Section</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(academic_plan, i) in academic_plans.data">
                            <td>{{ ++i }}</td>
                            <td>{{ academic_plan.academic_year.name }}</td>
                            <td>{{ academic_plan.academic_version }}</td>
                            <td>{{ academic_plan.academic_class.name }}</td>
                            <td>{{ academic_plan.academic_group ? academic_plan.academic_group.name : '' }}</td>
                            <td>{{ academic_plan.academic_section ? academic_plan.academic_section.name : '' }}</td>
                            <td>
                                <div class="action">
                                    <ul>
                                        <li>
                                            <Link :href="route('academic-plan.edit', academic_plan.id)" class="btn btn-sm btn-rounded btn-outline-primary"><i class="bx bx-edit"></i></Link>
                                        </li>
                                        <li>
                                            <button @click="deleteAction(academic_plan.id)" class="btn btn-sm btn-rounded btn-outline-danger"><i class="bx bx-trash"></i></button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <Pagination :data="academic_plans"/>
            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
