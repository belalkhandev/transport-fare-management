<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import NavLink from "../../Components/NavLink.vue";
import { ref } from 'vue';
import InputError from "../../Components/InputError.vue";
import Editor from "@tinymce/tinymce-vue";

const previewImage = ref(null);

const props = defineProps({
    transport_fee: {
        type: Object
    },
    fees: {
        type: Object,
        default: () => ({})
    }
})

const form = useForm({
    student_id: props.transport_fee.student_id,
    fee_id: props.transport_fee.fee_id ?? '',
    discounted_amount: props.transport_fee.discounted_amount ?? '',
    remarks:props.transport_fee.remarks ?? ''
});

const submitForm = () => {
    form.put(route('transport-fee.edit', props.transport_fee.id), {
        preserveScroll: true,
        onSuccess: () => {
            previewImage.value = null;
            Swal.fire(
                'Congratulation',
                'Transport fee has been updated successfully',
                'success'
            )
        }
    })
}

</script>

<template>
    <Head title="Transport fee edit" />
    <AdminPanelLayout>
        <template #header>Transport fee</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Edit transport fee</h5>
                <div class="action">
                    <NavLink :href="route('transport-fee.index')" class="btn btn-sm btn-outline-primary">Transport fees list</NavLink>
                </div>
            </div>
            <div class="box-body pb-4">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-md-12 col-lg-10 offset-lg-1">
                        <form @submit.prevent="submitForm">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-4 col-lg-3">Student</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="text" :value="transport_fee.student.name +  '- ' + transport_fee.student.student_id" class="form-control" readonly disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-4 col-lg-3">Fee</label>
                                <div class="col-md-8 col-lg-9">
                                    <select v-model="form.fee_id" class="form-control">
                                        <option value="">Select fee</option>
                                        <option v-for="fee in fees" :value="fee.id">{{ fee.area.name }} - {{ fee.amount }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.fee_id" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label  col-md-4 col-lg-3">Discounted Amount</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="number" v-model="form.discounted_amount" class="form-control" placeholder="0.00">
                                    <InputError class="mt-2" :message="form.errors.discounted_amount" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label  col-md-4 col-lg-3">Remarks</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea v-model="form.remarks" placeholder="Remarks" class="form-control-textarea form-control"></textarea>
                                    <InputError class="mt-2" :message="form.errors.remarks" />
                                </div>
                            </div>

                            <div class="form-group mt-4 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn-primary btn" :disabled="form.processing">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
