<script>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination } from "vue3-carousel";
import { defineComponent } from "vue";

export default defineComponent({
    name: 'MessageSlider',
    components: {
        Carousel,
        Slide,
        Pagination,
    },
})

</script>

<template>
    <section class="message-section section-padding-50">
        <Carousel class="message-slides" :autoplay="5000" :transition="1000" :wrap-around="true" :items-to-show="1" :pause-autoplay-on-hover="true">
            <Slide v-for="slide in 2" :key="slide">
                <div class="message-slide">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 col-lg-7">
                                <div class="message-slide-content">
                                    <h2>Message from Principal</h2>
                                    <p>I am honored to extend my warmest greetings to students, parents, teachers, staff, and all members of our esteemed school community. As the Principal of [School Name], it is my privilege to be a part of this vibrant and dynamic institution. At [School Name], we believe in fostering a nurturing environment where each student's potential is recognized, cultivated, and celebrated. Our dedicated team of educators is committed to providing a well-rounded education that goes beyond academics. We strive to empower our students with the knowledge, skills, and values they need to excel in an ever-changing world. As a school, we value open communication and collaboration between all stakeholders. We encourage parents and guardians to actively engage in their child's educational journey, and we welcome your input and involvement. Throughout the academic year, we offer a diverse range of opportunities for students to explore their interests, develop their talents, and grow as individuals. From arts to sports, academics to community service, there's something for everyone at [School Name]. I invite you to explore our website, where you'll find valuable information about our curriculum, extracurricular activities, upcoming events, and more."</p>
                                    <div class="message-author">
                                        <h3>Muhammad Abdul Kader Khan</h3>
                                        <p>Principal of the schools</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-5">
                                <div class="message-slide-thumbnail">
                                    <img src="@/assets/frontend/images/principal.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Slide>

            <template #addons>
                <Pagination />
            </template>
        </Carousel>
    </section>
</template>

<style scoped>


</style>
