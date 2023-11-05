<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import InputError from "@/Components/InputError.vue";
import SpinnerGlow from "@/Components/SpinnerGlow.vue";
import moment from "moment";

const props = defineProps({
    months: {
        type: Object
    },
    years: {
        type: Object
    },
    sms_format: {
        type: String
    }
});

const form = useForm({
    month: new Date().getMonth() + 1,
    year: new Date().getFullYear(),
    sms_format: props.sms_format
});


const formSubmit = () => {
    form.post(route('sms.due-alert'), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire(
                'Success',
                "Due alert sms successfully",
                'success'
            )
        },
        onError: (error) => {
            if (error.message) {
                Swal.fire(
                    'Opps!',
                    error.message,
                    'error'
                )
            }
        }
    })
}

</script>

<template>
    <Head title="Generate transport bill" />
    <AdminPanelLayout>
        <template #header>Due alert sms</template>

        <div class="row">
            <div class="col-xl-6 offset-xl-3 col-md-8 offset-md-2">
                <div class="box">
                    <SpinnerGlow v-if="form.processing"/>
                    <div class="box-header">
                        <h5 class="title">Send due alert sms</h5>
                    </div>
                    <div class="box-body">
                        <form @submit.prevent="formSubmit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Month</label>
                                        <select v-model="form.month" id="monthYear" class="form-select">
                                            <option v-for="month in months" :value=month.value>{{ month.name }}</option>
                                        </select>
                                        <InputError class="mt-2" :message="form.errors.month" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Year</label>
                                        <select v-model="form.year" id="monthYear" class="form-select">
                                            <option v-for="year in years" :value=year.value>{{ year.name }}</option>
                                        </select>
                                        <InputError class="mt-2" :message="form.errors.month" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Message Format</label>
                                        <textarea rows="5" class="form-control-textarea form-control" v-model="form.sms_format"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 text-danger p-1">Replace :due_date using a date (e.g: {{ moment().format('L') }}). But don't change :amount, :month_year, :payment_link. Or if you want to send a common sms to all you can change</div>
                            <div class="mb-4 text-warning bg-gray-50 p-1 font-sans">Only receive those who has due for the criteria</div>
                            <div class="form-group d-flex justify-end align-items-center">
                                <button type="submit" class="btn-primary btn" :disabled="form.processing">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer"></div>
                </div>
            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
