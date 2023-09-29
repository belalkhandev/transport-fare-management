<script setup>

import NavLink from "@/Components/NavLink.vue";
</script>

<template>
    <div class="main-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-menu">
                        <ul>
                            <li><NavLink :href="route('home')">
                                <i class="bx bxs-home"></i>
                            </NavLink></li>
                            <li class="color-info">
                                <NavLink :href="route('page.about-us')">{{ $t('about_us') }}</NavLink>
                                <ul class="submenu">
                                    <li><NavLink :href="route('page.construction')">Our aims</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Campus tour</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Our History</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Achievement</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Administrators</NavLink></li>
                                    <li><NavLink :href="route('governing-body.list')">Governing Body</NavLink></li>
                                    <li><NavLink :href="route('page.contact')">Contact Us</NavLink></li>
                                </ul>
                            </li>
                            <li class="color-red">
                                <NavLink :href="route('page.construction')">{{ $t('academics') }}</NavLink>
                                <ul class="submenu">
                                    <li><NavLink :href="route('teacher.list')">Our Teachers</NavLink></li>
                                    <li><NavLink :href="route('staff.list')">Our Staffs</NavLink></li>
                                    <li><NavLink :href="route('routine.class.list')">Class Schedule</NavLink></li>
                                    <li><NavLink :href="route('routine.exam.list')">Exam Schedule</NavLink></li>
                                    <li><NavLink :href="route('result.list')">Academic Result</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Academic Rules</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Academic Calender</NavLink></li>
                                </ul>
                            </li>
                            <li class="color-primary">
                                <NavLink :href="route('page.construction')">{{ $t('admission') }}</NavLink>
                                <ul class="submenu">
                                    <li><NavLink :href="route('page.construction')">How to Apply</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Admission Policy</NavLink></li>
                                </ul>
                            </li>
                            <li class="color-violet">
                                <NavLink :href="route('student.list')">Students</NavLink>
                                <ul class="submenu">
                                    <li><NavLink :href="route('student.list')">Student list</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Student Uniform</NavLink></li>
                                </ul>
                            </li>
                            <li class="color-info">
                                <NavLink :href="route('page.construction')">Facilities</NavLink>
                                <ul class="submenu">
                                    <li><NavLink :href="route('page.construction')">Library</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">ICT Lab</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Science Lab</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Play Ground</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Co-Curricular Activity</NavLink></li>
                                </ul>
                            </li>
                            <li class="color-black"><NavLink :href="route('result.show')">{{ $t('results') }}</NavLink></li>
                            <li class="color-maroon">
                                <NavLink :href="route('page.construction')">Gallery</NavLink>
                                <ul class="submenu">
                                    <li><NavLink :href="route('page.construction')">Photo Gallery</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Video Gallery</NavLink></li>
                                </ul>
                            </li>
                            <li><NavLink :href="route('notice.list')">Notices</NavLink></li>
                            <li class="color-orange">
                                <NavLink :href="route('page.construction')">Others</NavLink>
                                <ul class="submenu">
                                    <li><NavLink :href="route('page.construction')">Syllabus</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Download</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Events</NavLink></li>
                                    <li><NavLink :href="route('page.construction')">Blogs</NavLink></li>
                                </ul>
                            </li>
                            <li><NavLink :href="route('page.construction')">সুবর্ণজয়ন্তী কর্ণার</NavLink></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
