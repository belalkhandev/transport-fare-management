<script setup>
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    transport_bill: {
        type: Object,
    },
    student: {
        type: Object,
    },
});
</script>

<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="payment-box">
                    <div class="payment-box-header">
                        <img src="@/assets/images/bafsk-logo.png" alt="">
                        <div class="text-right">
                            <h3 class="text-center">BAFSK-Bus Payment</h3>
                        </div>
                    </div>
                    <div class="payment-box-content">
                        <div class="student">
                            <div class="student-avatar">
                                <img v-if="student.gender === 'male'" src="@/assets/images/male.png" alt="">
                                <img v-if="student.gender === 'female'" src="@/assets/images/female.png" alt="">
                            </div>
                            <div class="student-container">
                                <div class="student-container-top d-flex justify-content-between">
                                    <h4>{{ student.name }}</h4>
                                    <h4><span>Student ID: </span> {{ student.student_id }}</h4>
                                </div>
                                <div class="student-container-bottom">
                                    <div class="items">
                                        <ul>
                                            <li>Academic Year: 2023-24</li>
                                            <li>Class/Section: Nine/Science</li>
                                            <li>Group: Science</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-status text-center">
                            <img src="@/assets/images/payment-success.png" alt="">
                            <h2 class="text-success">Payment Already Completed</h2>
                            <p>This stage has been successfully completed. We acknowledge your progress and thank you for your dedication. If you have any further steps or inquiries, please feel free to reach out.</p>
                        </div>
                    </div>
                    <div class="payment-box-footer pt-4">
                        <div class="text-center">
                            <p>Developed By <a href="http://ideasolutionbd.com/">Idea solutionsBd</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
