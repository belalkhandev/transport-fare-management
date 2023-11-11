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
    note: '',
});


const formSubmit = () => {
    form.post(route('payment.refund', props.transport_bill.payment.trans_id), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire(
                'Success',
                "Refunded Successfully",
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
        <template #header>Payment Refund</template>

        <div class="row">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div class="box">
                    <SpinnerGlow v-if="form.processing"/>
                    <div class="box-header">
                        <h5 class="title">Refund</h5>
                    </div>
                    <div class="box-body">
                        <form @submit.prevent="formSubmit">
                            <div class="bg-yellow-50 text-yellow-700 p-2 rounded-2 font-sans">
                                <p>After submit refund you can't revert this</p>
                            </div>
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
                            <div class="form-group mt-2">
                                <label for="refund_note">Notes</label>
                                <textarea v-model="form.note" class="form-control form-control-textarea" rows="3" placeholder="Write refund note"></textarea>
                                <InputError class="mt-2" :message="form.errors.note" />
                            </div>

                            <div class="form-group mt-4 d-flex justify-end align-items-center">
                                <button type="submit" class="btn-primary btn" :disabled="form.processing">Refund</button>
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
