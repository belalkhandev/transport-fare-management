<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />
    <div id="login-wrap">
        <div class="login-box">
            <div class="login-header">
                <div class="logo">
                    <img src="@/assets/images/bafsk-logo.png" alt="">
                    <h2>Welcome to BAFSK BUS</h2>
                </div>
            </div>
            <div class="login-body">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="bx bx-user"></i>
                            </div>
                            <TextInput id="email" v-model="form.email" type="email" placeholder="ex: admin@example.com" class="form-control" autofocus autocomplete="username"/>
                        </div>
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="bx bxs-key"></i>
                            </div>
                            <TextInput id="password" v-model="form.password" type="password" autocomplete="current-password" placeholder="********"/>
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                    <div class="form-rem-pass">
                        <label>
                            <Checkbox v-model:checked="form.remember" name="remember" />
                            <span class="ml-2">Remember Me</span>
                        </label>
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">Login</button>
                    </div>
                </form>
            </div>
            <div class="login-footer text-center">
                <p>Can't access your account? <a href="#">Contact Us</a></p>
            </div>
        </div>
    </div>

</template>
