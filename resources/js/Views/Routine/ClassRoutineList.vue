<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NavLink from "@/Components/NavLink.vue";

</script>

<template>
    <AppLayout title="Class Routines">

        <div class="page section-padding-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area mb-4">
                            <h2 class="section-title">Class Routine list</h2>
                        </div>

                        <div class="notices">
                            <div class="notice-item" v-for="item in 10" :key="item">
                                <NavLink :href="route('routine.class.show')">
                                    <div class="notice-content">
                                        <ul>
                                            <li>
                                                <i class='bx bx-label'></i>
                                                <span>2023-2024 session</span>
                                            </li>
                                        </ul>
                                        <h3 class="notice-title">Class {{ item }}, section A Class routine</h3>
                                    </div>
                                </NavLink>
                                <div class="notice-attachment text-right">
                                    <a href="https://www.africau.edu/images/default/sample.pdf" target="_blank">
                                        <i class="bx bxs-file-pdf"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<style>

</style>
