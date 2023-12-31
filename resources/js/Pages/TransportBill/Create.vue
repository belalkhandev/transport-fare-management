<script setup>
import { useForm } from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import SpinnerGlow from "@/Components/SpinnerGlow.vue";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    months: {
        type: Object
    },
    years: {
        type: Object
    }
});

const form = useForm({

});

const search_form = useForm({
    student_id: ''
});

const searchStudentFormSubmit = () => {
    if (search_form.student_id) {
        ctx.$inertia.get(route('student.search'), { params: { student_id: search_form.student_id } })
        .then(response => {
            console.log(response);
        })
        .catch(error => {
            console.error(error);
        });
    }
}


const formSubmit = () => {
    form.post(route('transport-bill.create'), {
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
    <AdminPanelLayout :title="'Create bill for student'">
        <template #header>Create new bill</template>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="box">
                    <SpinnerGlow v-if="form.processing"/>
                    <div class="box-header">
                        <h5 class="title">New bill</h5>
                        <div class="action">
                            <NavLink :href="route('transport-bill.index')" class="btn btn-sm btn-outline-primary">Bill List</NavLink>
                        </div>
                    </div>
                    <div class="box-body">
                        <form @submit.prevent="formSubmit">

                            <div class="row">
                                <div class="col-md-4">
                                    <div >
                                        <div class="form-group">
                                            <input type="text" v-model="search_form.student_id" placeholder="Student ID" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" @click.prevent="searchStudentFormSubmit" class="btn btn-outline-primary">Search</button>
                                    <button type="reset" class="btn btn-outline-danger ml-2">Reset</button>
                                </div>
                            </div>


<!--                            <div class="form-check">-->
<!--                                <input class="form-check-input" v-model="form.send_sms" type="checkbox" id="flexCheckDefault">-->
<!--                                <label class="form-check-label" for="flexCheckDefault">-->
<!--                                    Send SMS?-->
<!--                                    <span v-if="form.send_sms" class="text-success">Yes</span>-->
<!--                                    <span v-else class="text-danger">No</span>-->
<!--                                </label>-->
<!--                            </div>-->

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
