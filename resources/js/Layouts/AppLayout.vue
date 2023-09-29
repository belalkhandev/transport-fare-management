<script setup>
import Header from "./Frontend/Header.vue";
import Footer from "./Frontend/Footer.vue";
import {Head} from "@inertiajs/vue3";
import Mainmenu from "@/Layouts/Frontend/Mainmenu.vue";
import HeroSlider from "@/Components/HeroSlider.vue";
import PageTitle from "@/Layouts/Frontend/PageTitle.vue";

defineProps({
    title: {
        type: String,
        Default: "School"
    },
});

const getActivePath = (routeName) => {
    const url = new URL(routeName)
    return url.pathname
}

</script>

<template>
    <Head :title="title"/>

    <Header />

    <section class="hero">
        <Mainmenu/>

        <HeroSlider v-if="$page.url === getActivePath(route('home'))"/>
        <PageTitle v-else :title="title"/>

    </section>

    <slot/>

    <Footer />

</template>

<style scoped>

</style>
