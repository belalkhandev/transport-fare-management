<script setup>
import {ref} from "vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    categories: {
        type: Object,
        default: () => ({})
    }
});

const displayCategoryModal = ref(false);

const showCategoryModal = () => {
    form.reset();
    displayCategoryModal.value = !displayCategoryModal.value
}

const form = useForm({
    category_ref: '',
    name: '',
    description: ''
})

const submitCategory = () => {
    if (!form.category_ref) {
        form.transform(data => ({
            ...data
        })).post(route('category.create'), {
            onSuccess: () => form.reset(),
        });
    } else {
        form.transform(data => ({
            ...data
        })).put(route('category.edit', form.category_ref), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'Category update successfully'
                });

                displayCategoryModal.value = false
            }
        });
    }
}

const editCategory = (category) => {
    form.category_ref = category.ref;
    form.name = category.name;
    form.description = category.description;

    displayCategoryModal.value = true
}


const deleteCategory = (category_ref) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0284c7',
        cancelButtonColor: '#DC2626',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('category.delete', category_ref), {
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Category has been deleted successfully'
                    });
                }
            })
        }
    })
}

</script>

<template>
    <Head title="Category" />
    <AdminPanelLayout>
        <template #header>Categories</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Categories</h5>
                <div class="action">
                    <button @click="showCategoryModal" class="btn btn-sm btn-rounded btn-outline-primary"><i class="bx bx-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ref</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, i) in categories.data">
                            <td>{{ i+1 }}</td>
                            <td>{{ category.ref }}</td>
                            <td>{{ category.name }}</td>
                            <td>{{ category.description }}</td>
                            <td>
                                <div class="action">
                                    <ul>
                                        <li>
                                            <button @click="editCategory(category)" class="btn btn-sm btn-rounded btn-outline-warning"><i class="bx bx-edit"></i></button>
                                        </li>
                                        <li>
                                            <button @click="deleteCategory(category.ref)" class="btn btn-sm btn-rounded btn-outline-danger"><i class="bx bx-trash"></i></button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <Pagination :data="categories"/>
            </div>
        </div>

        <DialogModal :show="displayCategoryModal"  @close="displayCategoryModal = false">
            <template #title>
                {{ form.category_ref ? 'Edit' : 'Add' }} Category
            </template>

            <template #content>
                <form @submit.prevent="submitCategory">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="form.name" placeholder="category name">
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="" placeholder="write description...." v-model="form.description" class="form-control form-control-textarea"></textarea>
                    </div>
                </form>
            </template>

            <template #footer>
                <SecondaryButton @click="displayCategoryModal = false">Cancel</SecondaryButton>
                <PrimaryButton @click="submitCategory" class="ml-3">{{ form.category_ref ? 'Update' : 'Save' }}</PrimaryButton>
            </template>
        </DialogModal>

    </AdminPanelLayout>
</template>

<style scoped>

</style>
