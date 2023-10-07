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
    academic_classes: {
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
    academic_class_id: '',
    name: '',
    numeric_name: '',
    is_active: true
})

const submitForm = () => {
    if (!form.academic_class_id) {
        form.transform(data => ({
            ...data
        })).post(route('academic-class.create'), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Academic class stored successfully'
                });
                form.reset();
            },
        });
    } else {
        form.transform(data => ({
            ...data
        })).put(route('academic-class.edit', form.academic_class_id), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Academic class update successfully'
                });

                displayFormModal.value = false
            }
        });
    }
}

const editAction = (academic_class) => {
    form.academic_class_id = academic_class.id;
    form.name = academic_class.name;
    form.numeric_name = academic_class.numeric_name;
    form.is_active = !!academic_class.is_active;

    displayFormModal.value = true
}


const deleteAction = (academic_class_id) => {
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
            form.delete(route('academic-class.delete', academic_class_id), {
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Academic class has been deleted successfully'
                    });
                }
            })
        }
    })
}

</script>

<template>
    <Head title="AcademicClass" />
    <AdminPanelLayout>
        <template #header>Academic classs</template>
        <div class="row">
            <div class="col-lg-8">
                <div class="box">
                    <div class="box-header">
                        <h5 class="title">Academic classs</h5>
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
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(academic_class, i) in academic_classes.data">
                                <td>{{ i+1 }}</td>
                                <td>{{ academic_class.name }}</td>
                                <td>
                                    <span v-if="academic_class.is_active" class="text-success">Active</span>
                                    <span v-else class="text-danger">Inactive</span>
                                </td>
                                <td>
                                    <div class="action">
                                        <ul>
                                            <li>
                                                <button @click="editAction(academic_class)" class="btn btn-sm btn-rounded btn-outline-warning"><i class="bx bx-edit"></i></button>
                                            </li>
                                            <li>
                                                <button @click="deleteAction(academic_class.id)" class="btn btn-sm btn-rounded btn-outline-danger"><i class="bx bx-trash"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <Pagination :data="academic_classes"/>
                    </div>
                </div>
            </div>
        </div>

        <DialogModal :show="displayFormModal"  @close="displayFormModal = false">
            <template #title>
                {{ form.academic_class_id ? 'Edit' : 'Add' }} Academic Class
            </template>

            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="form.name" placeholder="e.g: Nine">
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="form-group">
                        <label>Numeric Name</label>
                        <input type="text" class="form-control" v-model="form.numeric_name" placeholder="e.g: 9">
                        <InputError class="mt-2" :message="form.errors.numeric_name" />
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
                <PrimaryButton @click="submitForm" class="ml-3">{{ form.academic_class_id ? 'Update' : 'Save' }}</PrimaryButton>
            </template>
        </DialogModal>

    </AdminPanelLayout>
</template>

<style scoped>

</style>
