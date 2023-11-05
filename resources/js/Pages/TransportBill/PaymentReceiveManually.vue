<script setup>
import { useForm } from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import InputError from "@/Components/InputError.vue";
import SpinnerGlow from "@/Components/SpinnerGlow.vue";

const props = defineProps({
    student: {
        type: Object
    },
    transport_bill: {
        type: Object
    },
});

const form = useForm({
    payment_trans_id: '',
    gateway: '',
    transaction_date: '',
    send_sms: true
});


const formSubmit = () => {
    form.post(route('transport-bill.payment-manually', props.transport_bill.payment.trans_id), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire(
                'Success',
                "Payment received successfully",
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
    <AdminPanelLayout :title="'Generate transport bill'">
        <template #header>Payment Received</template>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="box">
                    <SpinnerGlow v-if="form.processing"/>
                    <div class="box-header">
                        <h5 class="title">Manually Payment Received: {{ transport_bill.payment.trans_id }}</h5>
                    </div>
                    <div class="box-body">
                        <form @submit.prevent="formSubmit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Student</label>
                                        <input type="text" :value="student.name" required class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Student ID</label>
                                        <input type="text" :value="student.student_id" required class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Payment For</label>
                                        <input type="text" :value="transport_bill.formatted_month_year" required class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Amount</label>
                                        <input type="text" :value="transport_bill.payment.amount" required class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Payment Transaction ID</label>
                                        <input type="text" v-model="form.payment_trans_id" required class="form-control" placeholder="e.g: BS35SK59Z">
                                        <InputError class="mt-2" :message="form.errors.payment_trans_id" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Gateway</label>
                                        <input type="text" v-model="form.gateway" required class="form-control" placeholder="e.g: Bkash, Rocket, Others">
                                        <InputError class="mt-2" :message="form.errors.gateway" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="monthYear">Payment Date</label>
                                        <input type="date" v-model="form.transaction_date" class="form-control">
                                        <InputError class="mt-2" :message="form.errors.transaction_date" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" v-model="form.send_sms" type="checkbox" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Send Confirmation SMS?
                                    <span v-if="form.send_sms" class="text-success">Yes</span>
                                    <span v-else class="text-danger">No</span>
                                </label>
                            </div>

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
