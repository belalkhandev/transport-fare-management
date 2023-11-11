<script setup>
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";

const getActivePath = (routeName) => {
    const url = new URL(routeName)
    return url.pathname
}

let sidebarHidden = ref(false);
const toggleSidebar = () => {
    sidebarHidden.value = !sidebarHidden.value
}

</script>

<template>
    <span class="sidebar-toggle" @click="toggleSidebar">
        <i class='bx bx-menu-alt-left'></i>
    </span>
    <aside class="sidebar" :class="{ 'toggle-sidebar': sidebarHidden }">
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
                        <li :class="{ 'active': $page.url === getActivePath(route('transport-bill.generate')) }">
                            <NavLink :href="route('transport-bill.generate')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Generate Transport Fee
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('transport-bill.index')) }">
                            <NavLink :href="route('transport-bill.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Transport bills
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('payment.index')) }">
                            <NavLink :href="route('payment.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Payment Transaction
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('transport-fee.index')) }">
                            <NavLink :href="route('transport-fee.index')">
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
                        <li :class="{ 'active': $page.url === getActivePath(route('student.create')) }">
                            <NavLink :href="route('student.create')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Add Student
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('student.index')) }">
                            <NavLink :href="route('student.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Student list
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('student.import')) }">
                            <NavLink :href="route('student.import')">
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
                        <li :class="{ 'active': $page.url === getActivePath(route('sms.send-sms')) }">
                            <NavLink :href="route('sms.send-sms')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Send SMS
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('sms.group-sms')) }">
                            <NavLink :href="route('sms.group-sms')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Send Group SMS
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('sms.due-alert')) }">
                            <NavLink :href="route('sms.due-alert')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Send Bulk Due Alert
                            </NavLink>
                        </li>
                        <li :class="{ 'active': $page.url === getActivePath(route('sms.logs')) }">
                            <NavLink :href="route('sms.logs')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                SMS Logs
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
                        <li :class="{ 'active': $page.url === getActivePath(route('academic-plan.index')) }">
                            <NavLink :href="route('academic-plan.index')">
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
                        <li :class="{ 'active': $page.url === getActivePath(route('settings.index')) }">
                            <NavLink :href="route('settings.index')">
                                <i class='bx bx-radio-circle-marked' ></i>
                                Settings
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
                        <li :class="{ 'active': $page.url === getActivePath(route('reports.sms')) }">
                            <NavLink :href="route('reports.sms')">
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
