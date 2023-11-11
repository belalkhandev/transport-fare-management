<script setup>
import Header from "./Header.vue";
import Sidebar from "./Sidebar.vue";
import {Head} from "@inertiajs/vue3";
import SpinnerGlow from "@/Components/SpinnerGlow.vue";

defineProps({
    title: String,
});

</script>

<template>
    <Head :title="title"/>
    <Header>
        <template #header>
            <slot name="header"/>
        </template>
    </Header>
    <div class="wrapper">
        <Sidebar/>
        <main class="main-content">
            <div class="content">
                <slot />
            </div>
        </main>
    </div>

</template>

<style scoped>

</style>
