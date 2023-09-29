<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AdminPanelLayout from "@/Layouts/AdminPanelLayout.vue";
import { ref } from 'vue';
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    settings: {
        type: Object,
        default: () => ({})
    }
});


const previewLogo = ref(props.settings && props.settings.site_logo ? props.settings.site_logo.src : null);
const onLogoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewLogo.value = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        previewLogo.value = null
    }
}

const previewFavicon = ref(props.settings && props.settings.site_favicon ? props.settings.site_favicon.src : null);

const onFaviconChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewFavicon.value = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        previewFavicon.value = null
    }
}

const previewFooterLogo =  ref(props.settings && props.settings.footer_logo ? props.settings.footer_logo.src : null);

const onFooterLogoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewFooterLogo.value = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        previewFooterLogo.value = null
    }
}

const form = useForm({
    site_title: props.settings ? props.settings.site_title : '',
    footer_summary:  props.settings ? props.settings.footer_summary : '',
    copyright_text:  props.settings ? props.settings.copyright_text : '',
    facebook:  props.settings ? props.settings.facebook : '',
    twitter:  props.settings ? props.settings.twitter : '',
    youtube:  props.settings ? props.settings.youtube : '',
    linkedin:  props.settings ? props.settings.linkedin : '',
    instagram:  props.settings ? props.settings.instagram : '',
    logo: '',
    favicon: '',
    footer_logo: '',
});

const submitSettings = () => {
    form.post(route('site.settings'), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire(
                'Success',
                'Setting has been changes successfully',
                'success'
            )
        }
    })
}

</script>

<template>
    <Head title="Site settings" />
    <AdminPanelLayout>
        <template #header>Site Settings</template>
        <div class="box">
            <div class="box-header">
                <h5 class="title">Site settings</h5>
            </div>
            <div class="box-body pb-4">
                <div class="row">
                    <div class="col-md-8">
                        <form @submit.prevent="submitSettings">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Site title</label>
                                <div class="col-sm-8">
                                    <input type="text" v-model="form.site_title" class="form-control">
                                    <InputError class="mt-1" :message="form.errors.site_title" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Main logo</label>
                                <div class="col-sm-8">
                                    <div class="file-upload-group">
                                        <div>
                                            <input type="file" @change="onLogoChange" class="form-control input-file" @input="form.logo = $event.target.files[0]">
                                        </div>
                                        <div class="preview-images" v-if="previewLogo">
                                            <div class="image">
                                                <img :src="previewLogo">
                                            </div>
                                        </div>
                                        <InputError class="mt-2" :message="form.errors.logo" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Favicon</label>
                                <div class="col-sm-8">
                                    <div class="file-upload-group">
                                        <div>
                                            <input type="file" @change="onFaviconChange" class="form-control input-file" @input="form.favicon = $event.target.files[0]">
                                        </div>
                                        <div class="preview-images" v-if="previewFavicon">
                                            <div class="image">
                                                <img :src="previewFavicon">
                                            </div>
                                        </div>
                                        <InputError class="mt-2" :message="form.errors.favicon" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Footer logo</label>
                                <div class="col-sm-8">
                                    <div class="file-upload-group">
                                        <div>
                                            <input type="file" @change="onFooterLogoChange" class="form-control input-file" @input="form.footer_logo = $event.target.files[0]">
                                        </div>
                                        <div class="preview-images" v-if="previewFooterLogo">
                                            <div class="image">
                                                <img :src="previewFooterLogo">
                                            </div>
                                        </div>
                                        <InputError class="mt-2" :message="form.errors.footer_logo" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Footer Copyright Text</label>
                                <div class="col-sm-8">
                                    <input type="text" v-model="form.copyright_text" class="form-control">
                                    <InputError class="mt-1" :message="form.errors.copyright_text" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Footer Summary</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control form-control-textarea" v-model="form.footer_summary" placeholder="write...."></textarea>
                                    <InputError class="mt-1" :message="form.errors.footer_summary" />
                                </div>
                            </div>

                            <h5 class="mb-4 mt-2 font-medium">Social links:
                                <hr>
                            </h5>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Facebook</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="enter facebook link" v-model="form.facebook">
                                    <InputError class="mt-1" :message="form.errors.facebook" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Twitter</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="enter twitter link" v-model="form.twitter">
                                    <InputError class="mt-1" :message="form.errors.twitter" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Youtube</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="enter youtube link" v-model="form.youtube">
                                    <InputError class="mt-1" :message="form.errors.youtube" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Linkedin</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="enter linkedin link" v-model="form.linkedin">
                                    <InputError class="mt-1" :message="form.errors.linkedin" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Instagram</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="enter instagram link" v-model="form.instagram">
                                    <InputError class="mt-1" :message="form.errors.instagram" />
                                </div>
                            </div>

                            <div class="form-group mt-4 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn-primary btn" :disabled="form.processing">Save changes</button>
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
