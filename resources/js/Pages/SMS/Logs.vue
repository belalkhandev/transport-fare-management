<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import Pagination from "../../Components/Pagination.vue";
import ActiveStatusLabel from "@/Components/ActiveStatusLabel.vue";
import moment from "moment";

const props = defineProps({
    logs: {
        type: Object,
        default: () => ({})
    }
});


</script>

<template>
    <Head title="SMS Logs" />
    <AdminPanelLayout>
        <template #header>SMS Logs</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">SMS History</h5>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th style="min-width: 120px;">SMS Count</th>
                            <th>Created at</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(sms, i) in logs.data">
                            <td>{{ logs.from + i }}</td>
                            <td>{{ sms.phone }}</td>
                            <td>{{ sms.message }}</td>
                            <td>{{ Math.ceil(sms.message.length/160) }}</td>
                            <td>{{ moment(sms.created_at).format('LLL') }}</td>
                            <td>
                                <div class="action">

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <Pagination :data="logs"/>
            </div>
        </div>
    </AdminPanelLayout>
</template>

<style scoped>

</style>
