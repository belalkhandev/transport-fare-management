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
                            <i class='bx bx-bus' ></i>
                        </span>
                    <h4>Transport Bill & Payment</h4>
                </div>
                <div class="sidebar-item-body">
                    <ul>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Generate Transport Fee
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Transport bill lists
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Payments
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Student Transport fees
                            </NavLink>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-item">
                <div class="sidebar-item-header">
                        <span class="icon">
                            <i class='bx bx-user' ></i>
                        </span>
                    <h4>Students</h4>
                </div>
                <div class="sidebar-item-body">
                    <ul>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                New Students
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Student list
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Student Bulk Import
                            </NavLink>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-item">
                <div class="sidebar-item-header">
                        <span class="icon">
                            <i class='bx bx-message-dots' ></i>
                        </span>
                    <h4>SMS Panel</h4>
                </div>
                <div class="sidebar-item-body">
                    <ul>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Send SMS
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Send Bulk SMS
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                SMS history
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
                    <h4>Configurations</h4>
                </div>
                <div class="sidebar-item-body">
                    <ul>
                        <li :class="{ 'active': $page.url === getActivePath(route('fee.index')) }">
                            <NavLink :href="route('fee.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Fees setup
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('area.index')) }">
                            <NavLink :href="route('area.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Areas
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Academic Plans
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('academic-year.index')) }">
                            <NavLink :href="route('academic-year.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Academic years
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('academic-class.index')) }">
                            <NavLink :href="route('academic-class.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Academic Class
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('academic-group.index')) }">
                            <NavLink :href="route('academic-group.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Academic Group
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('academic-section.index')) }">
                            <NavLink :href="route('academic-section.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Academic Section
                            </NavLink>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-item">
                <div class="sidebar-item-header">
                        <span class="icon">
                            <i class='bx bx-line-chart' ></i>
                        </span>
                    <h4>Reports</h4>
                </div>
                <div class="sidebar-item-body">
                    <ul>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Monthly Transactions
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                All Transactions
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Due Reports
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('site.settings')) }">
                            <NavLink :href="route('site.settings')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                SMS Reports
                            </NavLink>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </aside>
</template>

<style scoped>

</style>
