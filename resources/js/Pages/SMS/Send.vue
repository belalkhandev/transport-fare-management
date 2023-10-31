<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import NavLink from "../../Components/NavLink.vue";
import { ref } from 'vue';
import InputError from "../../Components/InputError.vue";
import Editor from "@tinymce/tinymce-vue";

const form = useForm({
    phone: '',
    message: ''
});

const submitForm = () => {
    form.post(route('sms.send-sms'), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire(
                'Congratulation',
                'SMS has been send successfully',
                'success'
            )
        }
    })
}

</script>

<template>
    <Head title="Send single sms" />
    <AdminPanelLayout>
        <template #header>Send SMS</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Send SMS</h5>
                <div class="action">
                    <NavLink :href="route('sms.logs')" class="btn btn-sm btn-outline-primary">SMS Logs</NavLink>
                </div>
            </div>
            <div class="box-body pb-4">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-md-12 col-lg-10 offset-lg-1">
                        <form @submit.prevent="submitForm">
                            <div class="form-group row">
                                <label class="col-form-label  col-md-4 col-lg-3">Phone</label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="text" v-model="form.phone" class="form-control" placeholder="88017xxxxxxxxx">
                                    <InputError class="mt-2" :message="form.errors.phone" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label  col-md-4 col-lg-3">Message</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea v-model="form.message" placeholder="Message" rows="5" class="form-control-textarea form-control"></textarea>
                                    <InputError class="mt-2" :message="form.errors.message" />
                                </div>
                            </div>

                            <div class="form-group mt-4 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn-primary btn" :disabled="form.processing">Submit</button>
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
