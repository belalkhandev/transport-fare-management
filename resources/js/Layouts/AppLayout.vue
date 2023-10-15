<script setup>
import {Head} from "@inertiajs/vue3";

defineProps({
    title: {
        type: String,
        Default: "Transport-bus billing"
    },
});

const getActivePath = (routeName) => {
    const url = new URL(routeName)
    return url.pathname
}

</script>

<template>
    <Head :title="title"/>
    <slot/>

</template>

<style scoped>

</style>
