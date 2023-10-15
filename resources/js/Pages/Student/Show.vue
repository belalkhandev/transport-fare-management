<script setup>
import {Head, Link} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import NavLink from "../../Components/NavLink.vue";

const props = defineProps({
    student: {
        type: Object,
        default: () => ({})
    }
});

</script>

<template>
    <Head title="Student Details" />
    <AdminPanelLayout>
        <template #header>Student details</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">{{ student.name }} - (Student ID: {{ student.student_id }})</h5>
                <div class="action">
                    <NavLink :href="route('student.index')" class="btn btn-sm btn-outline-primary">Student list</NavLink>
                </div>
            </div>
            <div class="box-body">
                <div>
                    <div class="row">
                        <div class="col-md-4">
                            <h4>{{ student.name }}</h4>
                            <table class="table table-borderless mt-2">
                                <tr>
                                    <td>Father name :</td>
                                    <td>{{ student.father_name }}</td>
                                </tr>
                                <tr>
                                    <td>Mother name :</td>
                                    <td>{{ student.mother_name }}</td>
                                </tr>
                                <tr>
                                    <td>Date of Birth :</td>
                                    <td>{{ student.dob }}</td>
                                </tr>
                                <tr>
                                    <td>Gender :</td>
                                    <td>{{ student.gender }}</td>
                                </tr>
                                <tr>
                                    <td>Blood Group :</td>
                                    <td>{{ student.blood_group }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <h5>Academic Information</h5>
                            <table v-if="student.academic_plans && student.academic_plans[0]" class="table table-borderless mt-2">
                                <tr>
                                    <td>Session :</td>
                                    <td>{{ student.academic_plans[0].academic_year.name }}</td>
                                </tr>
                                <tr>
                                    <td>Class :</td>
                                    <td>{{ student.academic_plans[0].academic_class.name }}</td>
                                </tr>
                                <tr>
                                    <td>Group :</td>
                                    <td>{{ student.academic_plans[0].academic_group.name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Section :</td>
                                    <td>{{ student.academic_plans[0].academic_section.name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Version :</td>
                                    <td>{{ student.academic_plans[0].academic_version ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-5">
                            <h5>Contact Details</h5>
                            <table class="table table-borderless mt-2">
                                <tr>
                                    <td>Contact no :</td>
                                    <td>{{ student.contact_no }}</td>
                                </tr>
                                <tr>
                                    <td>Email :</td>
                                    <td>{{ student.email }}</td>
                                </tr>
                                <tr>
                                    <td>Address Line 1 :</td>
                                    <td>{{ student.address_line_1 }}</td>
                                </tr>
                                <tr>
                                    <td>Address Line 2 :</td>
                                    <td>{{ student.address_line_2 }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
