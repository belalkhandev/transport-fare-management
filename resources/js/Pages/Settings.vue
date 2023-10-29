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
    settings: {
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
    setting_id: '',
    name: '',
    value: ''
})

const submitForm = () => {
    if (!form.setting_id) {
        form.transform(data => ({
            ...data
        })).post(route('settings.create'), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Academic section stored successfully'
                });
                form.reset();
            },
        });
    } else {
        form.transform(data => ({
            ...data
        })).put(route('settings.edit', form.setting_id), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Academic section update successfully'
                });

                displayFormModal.value = false
            }
        });
    }
}

const editAction = (setting) => {
    form.setting_id = setting.id;
    form.name = setting.name;
    form.is_active = !!setting.is_active;

    displayFormModal.value = true
}


const deleteAction = (setting_id) => {
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
            form.delete(route('academic-section.delete', setting_id), {
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Academic section has been deleted successfully'
                    });
                }
            })
        }
    })
}

</script>

<template>
    <Head title="Settings" />
    <AdminPanelLayout>
        <template #header>Settings</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Settings</h5>
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
                        <th>Value</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(setting, i) in settings.data">
                        <td>{{ i+1 }}</td>
                        <td>{{ setting.name }}</td>
                        <td>{{ setting.value }}</td>
                        <td>
                            <div class="action">
                                <ul>
                                    <li>
                                        <button @click="editAction(setting)" class="btn btn-sm btn-rounded btn-outline-warning"><i class="bx bx-edit"></i></button>
                                    </li>
                                    <li>
                                        <button @click="deleteAction(setting.id)" class="btn btn-sm btn-rounded btn-outline-danger"><i class="bx bx-trash"></i></button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <Pagination :data="settings"/>
            </div>
        </div>

        <DialogModal :show="displayFormModal"  @close="displayFormModal = false">
            <template #title>
                {{ form.setting_id ? 'Edit' : 'Add' }} Academic Section
            </template>

            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="form.name">
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="form-group">
                        <label>Value</label>
                        <textarea v-model="form.value" class="form-control"></textarea>
                        <InputError class="mt-2" :message="form.errors.value" />
                    </div>
                </form>
            </template>

            <template #footer>
                <SecondaryButton @click="displayFormModal = false">Cancel</SecondaryButton>
                <PrimaryButton @click="submitForm" class="ml-3">{{ form.setting_id ? 'Update' : 'Save' }}</PrimaryButton>
            </template>
        </DialogModal>

    </AdminPanelLayout>
</template>

<style scoped>

</style>
