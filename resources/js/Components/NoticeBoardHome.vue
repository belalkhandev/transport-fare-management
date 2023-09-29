<script setup>

import NavLink from "@/Components/NavLink.vue";
</script>

<template>
    <div class="notice-board-wrap home">
        <div class="section-title">
            <h2>Notice Board</h2>
            <NavLink class="btn btn-primary btn-sm" :href="route('home')">View All</NavLink>
        </div>
        <div class="notice-board">
            <div class="notice-items">
                <div class="notice-item" v-for="item in 4">
                    <NavLink :href="route('notice.show')">
                        <div class="notice-item-top">
                            <ul>
                                <li>
                                    <i class='bx bx-label'></i>
                                    <span>Notice by</span>
                                </li>
                                <li>
                                    <i class="bx bx-time "></i>
                                    <span>Aug 31, 2023 10:00 am</span>
                                </li>
                                <li>
                                    <span class="attachment">
                                        <i class="bx bxs-file-pdf"></i>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="notice-item-title">
                            <h5>COVID-19 Health Guidelines Update: Ensuring a Safe Learning</h5>
                        </div>
                    </NavLink>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
