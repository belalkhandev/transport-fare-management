<script setup>
import {Head} from "@inertiajs/vue3";
import Header from "@/Layouts/Payment/Header.vue";
import StudentProfile from "@/Components/StudentProfile.vue";
import Footer from "@/Layouts/Payment/Footer.vue";

const props = defineProps({
    title: String,
    student: {
        type: Object
    }
});

</script>

<template>
    <Head :title="title"/>
    <div class="payment-container">
        <Header/>
        <div class="payment-main-wrapper pb-12">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <StudentProfile :student="student"/>
                    </div>
                    <div class="col-md-8">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
        <Footer/>
    </div>
</template>

<style scoped>

</style>
