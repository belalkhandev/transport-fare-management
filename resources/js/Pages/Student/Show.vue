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
                <h5 class="title">Student list</h5>
                <div class="action">
                    <NavLink :href="route('student.index')" class="btn btn-sm btn-outline-primary">Student list</NavLink>
                </div>
            </div>
            <div class="box-body">
                {{ student.name }}
                {{ student.father_name }}
            </div>
            <div class="box-footer">

            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
