<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NavLink from "@/Components/NavLink.vue";

</script>

<template>
    <AppLayout title="Our Teachers">

        <div class="section-title-area section-padding-top-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Our Teachers</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="teachers">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3" v-for="teacher in 16">
                        <div class="teacher">
                            <NavLink :href="route('teacher.show')">
                                <img class="img-thumbnail" src="@/assets/frontend/images/people.jpg" alt="">
                                <div class="caption">
                                    <h5>Mr. Robert Jones</h5>
                                    <span>Principal</span>
                                </div>
                            </NavLink>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<style>

</style>
