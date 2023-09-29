<script setup>
import NavLink from "@/Components/NavLink.vue";
import LanguageSwitcher from "@/Components/LanguageSwitcher.vue";

</script>

<template>
    <header>
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="header-top-item left-item">
                            <p>SCHOOL CODE: 235476 | {{ $t('eiin_code') }} 23456</p>
                        </div>
                    </div>
                    <div class="col-md-7 offset-md-1">
                        <div class="header-top-item">
                            <LanguageSwitcher/>
                            <ul class="right">
                                <li>
                                <span>
                                    <i class="bx bx-phone"></i>
                                    +880 1798 XXX XXX
                                </span>
                                </li>
                                <li>
                                <span>
                                    <i class="bx bx-envelope"></i>
                                    info@school.com
                                </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="content">
                            <div class="logo">
                                <NavLink :href="route('home')">
                                    <img src="@/assets/frontend/images/logo.png" alt="School logo">
                                    <div class="logo-content">
                                        <h2>Bhatpeary J.R.S High School</h2>
                                        <h4>ভাটপিয়ারী জ. রা সা উচ্চ বিদ্যালয়</h4>
                                    </div>
                                </NavLink>
                            </div>
                            <div class="logo-m100">
                                <img src="@/assets/frontend/images/mujeeb100.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
</template>

<style>

</style>
