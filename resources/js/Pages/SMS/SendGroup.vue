<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import NavLink from "../../Components/NavLink.vue";
import InputError from "../../Components/InputError.vue";
import Multiselect from "@vueform/multiselect";
import '@vueform/multiselect/themes/default.css'

const props = defineProps({
    areas: {
        type: Object
    }
});

const form = useForm({
    receiver: 'only_active',
    area: null,
    message: ''
});

const submitForm = () => {
    form.post(route('sms.group-sms'), {
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

const smsCount = () => {
    const messageLength = form.message.length;
    return Math.ceil(messageLength / 160);
};

const preparedAreas = props.areas.map(area => area.name);


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
                                <label class="col-form-label  col-md-4 col-lg-3">Audience</label>
                                <div class="col-md-8 col-lg-9">
                                    <ul>
                                        <li>
                                            <label>
                                                <input type="radio" v-model="form.receiver" value="all">
                                                All Students
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" v-model="form.receiver" value="only_active">
                                                Only Active Students
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" v-model="form.receiver" value="area">
                                                Area (Active student)
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="form-group mt-2" v-if="form.receiver === 'area'">
                                        <Multiselect
                                            v-model="form.area"
                                            :options="preparedAreas"
                                            :mode="'single'"
                                            :searchable="true"
                                            :placeholder="'Select area'"
                                        >

                                        </Multiselect>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label  col-md-4 col-lg-3">Message</label>
                                <div class="col-md-8 col-lg-9">
                                    <textarea v-model="form.message" placeholder="Message" rows="5" class="form-control-textarea form-control"></textarea>
                                    <small>Character Count: {{ form.message.length }}, SMS Count: {{ smsCount() }}</small>
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
