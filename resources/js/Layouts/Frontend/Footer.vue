<script setup>

import NavLink from "@/Components/NavLink.vue";
</script>

<template>
    <footer>
        <div class="footer-top section-padding-50">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-item">
                            <div class="footer-content">
                                <div class="logo">
                                    <NavLink :href="route('home')">
                                        <img src="@/assets/frontend/images/logo.png" alt="School logo">
                                        <div class="logo-content">
                                            <h2>Bhatpeary J.R.S High School</h2>
                                            <h4>ভাটপিয়ারী জ. রা সা উচ্চ বিদ্যালয়</h4>
                                        </div>
                                    </NavLink>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-item">
                            <div class="footer-title">
                                <h3>Useful links</h3>
                            </div>
                            <div class="footer-content">
                                <ul class="footer-navs">
                                    <li v-for="item in 9">
                                        <a href="">
                                            <i class='bx bx-chevron-right'></i>
                                            <span>Links name test {{ item }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-item">
                            <div class="footer-title">
                                <h3>Find us on map</h3>
                            </div>
                            <div class="footer-content">
                                <div id="gmap">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d11530.416481699074!2d89.70003245576997!3d24.455860295892865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1693660866710!5m2!1sen!2sbd"
                                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="footer-copyright">
                            <p>Copyright &copy; 2023 All Rights Reserved By Schoo@Example</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-text text-right">
                            <p>Design & Developed By <a href="">IdeaSolutionsBD</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<style>

</style>
