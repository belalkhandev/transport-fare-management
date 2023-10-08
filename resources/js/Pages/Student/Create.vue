<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import NavLink from "../../Components/NavLink.vue";
import { ref } from 'vue';
import InputError from "../../Components/InputError.vue";
import Editor from "@tinymce/tinymce-vue";

const previewImage = ref(null);

const props = defineProps({
    gender: {
        type: Array,
    },
    blood_group: {
        type: Array,
    },
    academic_plans: {
        type: Object,
        default: () => ({})
    }
})


const form = useForm({
    student_id: '',
    name: '',
    father_name: '',
    mother_name: '',
    gender: '',
    blood_group: '',
    dob: '',
    contact_no: '',
    emergency_contact_no: '',
    email: '',
    is_active: true,
    address_line_1: '',
    address_line_2: '',
    academic_plan_id: '',
});

const submitForm = () => {
    form.post(route('student.create'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            previewImage.value = null;
            Swal.fire(
                'Congratulation',
                'Student has been stored successfully',
                'success'
            )
        }
    })
}

</script>

<template>
    <Head title="Add student" />
    <AdminPanelLayout>
        <template #header>Student</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Add new student</h5>
                <div class="action">
                    <NavLink :href="route('student.index')" class="btn btn-sm btn-outline-primary">Student list</NavLink>
                </div>
            </div>
            <div class="box-body pb-4">
                <div class="row">
                    <div class="col-md-12 col-lg-10 offset-lg-1">
                        <form @submit.prevent="submitForm">
                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-4">Academic Plan</label>
                                <div class="col-md-8">
                                    <select v-model="form.academic_plan_id" class="form-control">
                                        <option value="">Select academic plan</option>
                                        <option v-for="academic_plan in academic_plans" :value="academic_plan.id">{{ academic_plan.name }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.academic_plan_id" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-4">Student ID</label>
                                <div class="col-md-8">
                                    <input type="text" v-model="form.student_id" class="form-control" placeholder="Enter student id">
                                    <InputError class="mt-2" :message="form.errors.student_id" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-4">Name</label>
                                <div class="col-md-8">
                                    <input type="text" v-model="form.name" class="form-control" placeholder="Enter student name">
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-4">Father name</label>
                                <div class="col-md-8">
                                    <input type="text" v-model="form.father_name" class="form-control" placeholder="Enter father name">
                                    <InputError class="mt-2" :message="form.errors.father_name" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-4">Mother name</label>
                                <div class="col-md-8">
                                    <input type="text" v-model="form.mother_name" class="form-control" placeholder="Enter mother name">
                                    <InputError class="mt-2" :message="form.errors.mother_name" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-4">Date of Birth (DOB)</label>
                                <div class="col-md-8">
                                    <input type="date" v-model="form.dob" class="form-control">
                                    <InputError class="mt-2" :message="form.errors.dob" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-4">Gender</label>
                                <div class="col-md-8">
                                    <select v-model="form.gender" class="form-control">
                                        <option value="">Select gender</option>
                                        <option v-for="item in gender" :value="item">{{ item }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.gender" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-4">Blood Group</label>
                                <div class="col-md-8">
                                    <select v-model="form.blood_group" class="form-control">
                                        <option value="">Select blood group</option>
                                        <option v-for="item in blood_group" :value="item">{{ item }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.blood_group" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-4">Contact no</label>
                                <div class="col-md-8">
                                    <input type="text" v-model="form.contact_no" class="form-control" placeholder="Enter contact no">
                                    <InputError class="mt-2" :message="form.errors.contact_no" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-4">Emergency contact no</label>
                                <div class="col-md-8">
                                    <input type="text" v-model="form.emergency_contact_no" class="form-control" placeholder="Enter emergency contact no">
                                    <InputError class="mt-2" :message="form.errors.emergency_contact_no" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-4">Email</label>
                                <div class="col-md-8">
                                    <input type="email" v-model="form.email" class="form-control" placeholder="Enter email">
                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-4">Address line 1</label>
                                <div class="col-md-8">
                                    <input type="text" v-model="form.address_line_1" class="form-control" placeholder="Enter address line 1">
                                    <InputError class="mt-2" :message="form.errors.address_line_1" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-md-4">address line 2</label>
                                <div class="col-md-8">
                                    <input type="text" v-model="form.address_line_2" class="form-control" placeholder="Enter  address line 2">
                                    <InputError class="mt-2" :message="form.errors.address_line_2" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-4">Student Status</label>
                                <div class="col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input" v-model="form.is_active" type="checkbox" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <span v-if="form.is_active" class="text-success">Active</span>
                                            <span v-else class="text-danger">Inactive</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn-primary btn" :disabled="form.processing">Save</button>
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
