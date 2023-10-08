<script setup>
import {ref} from "vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    academic_years: {
        type: Object,
        default: () => ({})
    }
});

const displayFormModal = ref(false);

const showFormModal = () => {
    form.reset();
    displayFormModal.value = !displayFormModal.value
}

const form = useForm({
    academic_year_id: '',
    name: '',
    start_date: '',
    end_date: '',
    is_active: true
})

const submitForm = () => {
    if (!form.academic_year_id) {
        form.transform(data => ({
            ...data
        })).post(route('academic-year.create'), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Academic year stored successfully'
                });
                form.reset();
            },
        });
    } else {
        form.transform(data => ({
            ...data
        })).put(route('academic-year.edit', form.academic_year_id), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Academic year update successfully'
                });

                displayFormModal.value = false
            }
        });
    }
}

const editAction = (academic_year) => {
    form.academic_year_id = academic_year.id;
    form.name = academic_year.name;
    form.start_date = academic_year.start_date;
    form.end_date = academic_year.end_date;
    form.is_active = !!academic_year.is_active;

    displayFormModal.value = true
}


const deleteAction = (academic_year_id) => {
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
            form.delete(route('academic-year.delete', academic_year_id), {
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Academic year has been deleted successfully'
                    });
                }
            })
        }
    })
}

</script>

<template>
    <Head title="AcademicYear" />
    <AdminPanelLayout>
        <template #header>Academic years</template>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header">
                        <h5 class="title">Academic years</h5>
                        <div class="action">
                            <button @click="showFormModal" class="btn btn-sm btn-rounded btn-outline-primary"><i class="bx bx-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Start date</th>
                                <th>End date</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(academic_year, i) in academic_years.data">
                                <td>{{ i+1 }}</td>
                                <td>{{ academic_year.name }}</td>
                                <td>{{ academic_year.start_date }}</td>
                                <td>{{ academic_year.end_date }}</td>
                                <td>
                                    <span v-if="academic_year.is_active" class="text-success">Active</span>
                                    <span v-else class="text-danger">Inactive</span>
                                </td>
                                <td>
                                    <div class="action">
                                        <ul>
                                            <li>
                                                <button @click="editAction(academic_year)" class="btn btn-sm btn-rounded btn-outline-warning"><i class="bx bx-edit"></i></button>
                                            </li>
                                            <li>
                                                <button @click="deleteAction(academic_year.id)" class="btn btn-sm btn-rounded btn-outline-danger"><i class="bx bx-trash"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <Pagination :data="academic_years"/>
                    </div>
                </div>
            </div>
        </div>

        <DialogModal :show="displayFormModal"  @close="displayFormModal = false">
            <template #title>
                {{ form.academic_year_id ? 'Edit' : 'Add' }} Academic Year
            </template>

            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="form.name" placeholder="e.g: 2023-24">
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label>Start Date</label>
                               <input type="date" class="form-control" v-model="form.start_date">
                               <InputError class="mt-2" :message="form.errors.start_date" />
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label>End Date</label>
                               <input type="date" class="form-control" v-model="form.end_date">
                               <InputError class="mt-2" :message="form.errors.end_date" />
                           </div>
                       </div>
                   </div>

                    <div class="form-check">
                        <input class="form-check-input" v-model="form.is_active" type="checkbox" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Status
                            <span v-if="form.is_active" class="text-success">Active</span>
                            <span v-else class="text-danger">Inactive</span>
                        </label>
                    </div>
                </form>
            </template>

            <template #footer>
                <SecondaryButton @click="displayFormModal = false">Cancel</SecondaryButton>
                <PrimaryButton @click="submitForm" class="ml-3">{{ form.academic_year_id ? 'Update' : 'Save' }}</PrimaryButton>
            </template>
        </DialogModal>

    </AdminPanelLayout>
</template>

<style scoped>

</style>
