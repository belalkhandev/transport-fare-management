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
    fees: {
        type: Object,
        default: () => ({})
    },
    areas: {
        type: Object,
        default: () => ({})
    },
});

const displayFormModal = ref(false);

const showFormModal = () => {
    form.reset();
    displayFormModal.value = !displayFormModal.value
}

const form = useForm({
    fee_id: '',
    area_id: '',
    amount: '',
})

const submitForm = () => {
    if (!form.fee_id) {
        form.transform(data => ({
            ...data
        })).post(route('fee.create'), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Fee stored successfully'
                });
                form.reset();
            },
        });
    } else {
        form.transform(data => ({
            ...data
        })).put(route('fee.edit', form.fee_id), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Fee update successfully'
                });

                displayFormModal.value = false
            }
        });
    }
}

const editAction = (fee) => {
    form.fee_id = fee.id;
    form.area_id = fee.area_id;
    form.amount = fee.amount;
    displayFormModal.value = true
}


const deleteAction = (fee_id) => {
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
            form.delete(route('fee.delete', fee_id), {
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Fee has been deleted successfully'
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
        <template #header>Fees</template>
        <div class="row">
            <div class="col-lg-8">
                <div class="box">
                    <div class="box-header">
                        <h5 class="title">Fees</h5>
                        <div class="action">
                            <button @click="showFormModal" class="btn btn-sm btn-rounded btn-outline-primary"><i class="bx bx-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Area</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(fee, i) in fees.data">
                                <td>{{ i+1 }}</td>
                                <td>{{ fee.area.name }}</td>
                                <td>{{ fee.amount }}</td>
                                <td>
                                    <div class="action">
                                        <ul>
                                            <li>
                                                <button @click="editAction(fee)" class="btn btn-sm btn-rounded btn-outline-warning"><i class="bx bx-edit"></i></button>
                                            </li>
                                            <li>
                                                <button @click="deleteAction(fee.id)" class="btn btn-sm btn-rounded btn-outline-danger"><i class="bx bx-trash"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <Pagination :data="fees"/>
                    </div>
                </div>
            </div>
        </div>

        <DialogModal :show="displayFormModal"  @close="displayFormModal = false">
            <template #title>
                {{ form.fee_id ? 'Edit' : 'Add' }} fee
            </template>

            <template #content>
                <form @submit.prevent="submitForm">
                    <div class="form-group">
                        <label for="">Area</label>
                        <select v-model="form.area_id" class="form-control">
                            <option value="">Select Area</option>
                            <option v-for="area in areas" :value="area.id">{{ area.name }}</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.area_id" />
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" min="0" class="form-control" v-model="form.amount" placeholder="0.00">
                        <InputError class="mt-2" :message="form.errors.amount" />
                    </div>
                </form>
            </template>

            <template #footer>
                <SecondaryButton @click="displayFormModal = false">Cancel</SecondaryButton>
                <PrimaryButton @click="submitForm" class="ml-3">{{ form.fee_id ? 'Update' : 'Save' }}</PrimaryButton>
            </template>
        </DialogModal>

    </AdminPanelLayout>
</template>

<style scoped>

</style>
