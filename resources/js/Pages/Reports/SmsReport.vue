<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import ActiveStatusLabel from "@/Components/ActiveStatusLabel.vue";
import moment from "moment";

const props = defineProps({
    reports: {
        type: Object,
        default: () => ({})
    }
});


</script>

<template>
    <AdminPanelLayout :title="'SMS Reports'">
        <template #header>SMS Reports</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">SMS Reports</h5>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th class="text-center">Total Sent</th>
                            <th class="text-center">Total SMS Count</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(report, i) in reports">
                        <td>{{ i+1 }}</td>
                        <td>{{ moment(report.month).format('MMMM') }}</td>
                        <td>{{ moment(report.month).format('Y') }}</td>
                        <td class="text-center">{{ report.total_count }}</td>
                        <td class="text-center">{{ report.sms_count }}</td>
                    </tr>
                    </tbody>

                </table>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
