<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import InputError from "@/Components/InputError.vue";


const form = useForm({
    import_file: '',
});

const formSubmit = () => {
    form.post(route('student.import'), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire(
                'Success',
                'Imported has been changes successfully',
                'success'
            )
        }
    })
}

</script>

<template>
    <Head title="Student bulk import" />
    <AdminPanelLayout>
        <template #header>Student bulk import</template>

        <div class="row">
            <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                <div class="box">
                    <div class="box-header">
                        <h5 class="title">Bulk import</h5>
                    </div>
                    <div class="box-body">
                        <form @submit.prevent="formSubmit" enctype="multipart/form-data">
                            <div class="form-group mt-2">
                                <label for="formFile">Choose a CSV file to bulk student import</label>
                                <input class="form-control" type="file" id="formFile" @input="form.import_file = $event.target.files[0]">
                                <InputError class="mt-2" :message="form.errors.import_file" />
                            </div>
                            <div class="mb-4 text-warning bg-gray-50 p-1 font-sans"> To get started, we've attached a sample file for your convenience. Ensure that your data is correctly formatted and follows the provided template before uploading. This will help streamline the process and prevent any issues during import. <span class="text-danger">Duplicate Student-ID will be ignored</span></div>
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="" download="" class="btn btn-sm btn-outline-info"><i class="bx bx-download"></i> Sample CSV</a>
                                </div>
                                <button type="submit" class="btn-primary btn" :disabled="form.processing">Upload</button>
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
