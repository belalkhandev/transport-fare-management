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

const displayAcademicYearModal = ref(false);

const showAcademicYearModal = () => {
    form.reset();
    displayAcademicYearModal.value = !displayAcademicYearModal.value
}

const form = useForm({
    academic_year_id: '',
    name: '',
    is_active: true
})

const submitAcademicYear = () => {
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

                displayAcademicYearModal.value = false
            }
        });
    }
}

const editAcademicYear = (academic_year) => {
    form.academic_year_id = academic_year.id;
    form.name = academic_year.name;
    form.is_active = !!academic_year.is_active;

    displayAcademicYearModal.value = true
}


const deleteAcademicYear = (academic_year_id) => {
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
            <div class="col-lg-8">
                <div class="box">
                    <div class="box-header">
                        <h5 class="title">Academic years</h5>
                        <div class="action">
                            <button @click="showAcademicYearModal" class="btn btn-sm btn-rounded btn-outline-primary"><i class="bx bx-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(academic_year, i) in academic_years.data">
                                <td>{{ i+1 }}</td>
                                <td>{{ academic_year.name }}</td>
                                <td>
                                    <span v-if="academic_year.is_active" class="text-success">Active</span>
                                    <span v-else class="text-danger">Inactive</span>
                                </td>
                                <td>
                                    <div class="action">
                                        <ul>
                                            <li>
                                                <button @click="editAcademicYear(academic_year)" class="btn btn-sm btn-rounded btn-outline-warning"><i class="bx bx-edit"></i></button>
                                            </li>
                                            <li>
                                                <button @click="deleteAcademicYear(academic_year.id)" class="btn btn-sm btn-rounded btn-outline-danger"><i class="bx bx-trash"></i></button>
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

        <DialogModal :show="displayAcademicYearModal"  @close="displayAcademicYearModal = false">
            <template #title>
                {{ form.academic_year_id ? 'Edit' : 'Add' }} Academic Year
            </template>

            <template #content>
                <form @submit.prevent="submitAcademicYear">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="form.name" placeholder="e.g: 2023-24">
                        <InputError class="mt-2" :message="form.errors.name" />
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
                <SecondaryButton @click="displayAcademicYearModal = false">Cancel</SecondaryButton>
                <PrimaryButton @click="submitAcademicYear" class="ml-3">{{ form.academic_year_id ? 'Update' : 'Save' }}</PrimaryButton>
            </template>
        </DialogModal>

    </AdminPanelLayout>
</template>

<style scoped>

</style>
