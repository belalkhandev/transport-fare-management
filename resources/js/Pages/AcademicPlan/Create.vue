<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import NavLink from "../../Components/NavLink.vue";
import { ref } from 'vue';
import InputError from "../../Components/InputError.vue";
import Editor from "@tinymce/tinymce-vue";

const previewImage = ref(null);

const props = defineProps({
    versions: {
        type: Array,
    },
    academic_years: {
        type: Object,
        default: () => ({})
    },
    academic_classes: {
        type: Object,
        default: () => ({})
    },
    academic_groups: {
        type: Object,
        default: () => ({})
    },
    academic_sections: {
        type: Object,
        default: () => ({})
    },
})


const form = useForm({
    academic_year_id: '',
    academic_class_id: '',
    academic_group_id: '',
    academic_section_id: '',
    version: '',
});

const createForm = () => {
    form.post(route('academic-plan.create'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            previewImage.value = null;
            Swal.fire(
                'Congratulation',
                'Academic plan has been stored successfully',
                'success'
            )
        }
    })
}

</script>

<template>
    <Head title="Project Create" />
    <AdminPanelLayout>
        <template #header>Academic plan</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Create plan</h5>
                <div class="action">
                    <NavLink :href="route('academic-plan.index')" class="btn btn-sm btn-outline-primary">Plan list</NavLink>
                </div>
            </div>
            <div class="box-body pb-4">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                        <form @submit.prevent="createForm">
                            <div class="form-group">
                                <label for="">Academic Year</label>
                                <select v-model="form.academic_year_id" class="form-control">
                                    <option value="">Select year</option>
                                    <option v-for="academic_year in academic_years" :value="academic_year.id">{{ academic_year.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.academic_year_id" />
                            </div>
                            <div class="form-group">
                                <label for="">Academic Class</label>
                                <select v-model="form.academic_class_id" class="form-control">
                                    <option value="">Select class</option>
                                    <option v-for="academic_class in academic_classes" :value="academic_class.id">{{ academic_class.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.academic_class_id" />
                            </div>
                            <div class="form-group">
                                <label for="">Academic Group</label>
                                <select v-model="form.academic_group_id" class="form-control">
                                    <option value="">Select group</option>
                                    <option v-for="academic_group in academic_groups" :value="academic_group.id">{{ academic_group.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.academic_group_id" />
                            </div>
                            <div class="form-group">
                                <label for="">Academic Section</label>
                                <select v-model="form.academic_section_id" class="form-control">
                                    <option value="">Select section</option>
                                    <option v-for="academic_section in academic_sections" :value="academic_section.id">{{ academic_section.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.academic_section_id" />
                            </div>
                            <div class="form-group">
                                <label for="">Version</label>
                                <select v-model="form.version" class="form-control">
                                    <option value="">Select version</option>
                                    <option v-for="version in versions" :value="version.id">{{ version.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.version" />
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
