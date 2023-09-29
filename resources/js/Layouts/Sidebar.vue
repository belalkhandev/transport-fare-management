<script setup>
import NavLink from "@/Components/NavLink.vue";

const getActivePath = (routeName) => {
    const url = new URL(routeName)
    return url.pathname
}
</script>

<template>
    <aside class="sidebar">
        <div class="sidebar-items">
            <div class="sidebar-item">
                <div class="sidebar-item-body">
                    <ul>
                        <li :class="{ 'active': $page.url === getActivePath(route('dashboard')) }">
                            <NavLink :href="route('dashboard')">
                                <i class="bx bx-tachometer"></i>
                                Dashboard
                            </NavLink>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-item">
                <div class="sidebar-item-header">
                        <span class="icon">
                            <i class="bx bx-cog"></i>
                        </span>
                    <h4>Users & Settings</h4>
                </div>
                <div class="sidebar-item-body">
                    <ul>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">Site Settings</NavLink>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </aside>
</template>

<style scoped>

</style>
