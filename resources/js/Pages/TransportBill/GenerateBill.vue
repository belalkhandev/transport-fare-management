<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import InputError from "@/Components/InputError.vue";
import SpinnerGlow from "@/Components/SpinnerGlow.vue";

const props = defineProps({
    months: {
        type: Object
    }
});

const form = useForm({
    month: new Date().getMonth() + 1,
    year: new Date().getFullYear()
});


const formSubmit = () => {
    form.post(route('student.import'), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire(
                'Success',
                "Bill generated successfully",
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
        <template #header>Generate transport bills</template>

        <div class="row">
            <div class="col-xl-6 offset-xl-3 col-md-8 offset-md-2">
                <div class="box">
                    <SpinnerGlow v-if="form.processing"/>
                    <div class="box-header">
                        <h5 class="title">Generate Bill</h5>
                    </div>
                    <div class="box-body">
                        <form @submit.prevent="formSubmit" enctype="multipart/form-data">
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
                                        <input type="text" v-model="form.year" class="form-control" readonly disabled>
                                        <InputError class="mt-2" :message="form.errors.month" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 text-warning bg-gray-50 p-1 font-sans">If any bill already generated for any student then that will be updated with new configuration</div>
                            <div class="form-group d-flex justify-end align-items-center">
                                <button type="submit" class="btn-primary btn" :disabled="form.processing">Generate</button>
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
