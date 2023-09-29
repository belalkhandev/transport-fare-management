<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NavLink from "@/Components/NavLink.vue";

</script>

<template>
    <AppLayout title="Notice Details">

        <div class="page section-padding-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="notice-details">
                            <div class="notice-item">
                                <h3 class="notice-title">Lorem ipsum dolor sit amet, consectetur adipisicing.</h3>
                                <ul>
                                    <li>
                                        <i class='bx bx-label'></i>
                                        <span>Admin Notice</span>
                                    </li>
                                    <li>
                                        <i class="bx bx-time "></i>
                                        <span>Aug 31, 2023 10:00 am</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="notice-content">
                                <embed src="https://www.africau.edu/images/default/sample.pdf" type="application/pdf" style="width: 100%;height: 770px" />
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
