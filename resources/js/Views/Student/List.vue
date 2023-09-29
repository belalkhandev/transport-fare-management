<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NavLink from "@/Components/NavLink.vue";

</script>

<template>
    <AppLayout title="Our Students">

        <div class="section-title-area section-padding-top-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Students list</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="students">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-4" v-for="student in 24" :key="student">
                        <div class="student">
                            <NavLink :href="route('student.show')">
                                <div class="student-img">
                                    <img src="@/assets/frontend/images/student.jpg" alt="">
                                </div>
                                <div class="student-caption">
                                    <h5 class="name">Mr. Muhib Sheikh</h5>
                                    <ul>
                                        <li>ID: 123456</li>
                                        <li>Class: Seven</li>
                                        <li>Session: 2023-24</li>
                                    </ul>
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
