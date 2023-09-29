<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import NewsTicker from "@/Components/NewTicker.vue";
import MessageSlider from "@/Components/MessageSlider.vue";
import NoticeBoardHome from "@/Components/NoticeBoardHome.vue";
import GalleryCarousel from "@/Components/GalleryCarousel.vue";
import NavLink from "@/Components/NavLink.vue";

</script>

<template>
    <AppLayout title="School website">

        <NewsTicker/>

        <section class="welcome-section section-padding-50">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="welcome-content">
                            <h2>Welcome Lorem ipsum dolor sit.</h2>
                            <p>At [School Name], education is more than just  education is more than just imparting knowledge; it's about fostering a holistic growth that equips students for a lifetime of success. Our school stands as a beacon of excellence, committed to nurturing young minds and cultivating well-rounded individuals. Located in the heart of [Location], [School Name] offers a dynamic learning environment where academic rigor meets a rich tapestry of extracurricular opportunities. With a team of dedicated educators, we prioritize personalized learning, ensuring that each student's unique potential is recognized and nurtured.</p>
                            <NavLink :href="route('page.about-us')" class="btn btn-light mt-1">View More</NavLink>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <NoticeBoardHome/>
                    </div>
                </div>
            </div>
        </section>

        <MessageSlider/>

        <section class="people-section section-padding-50">
            <div class="section-title-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title text-center">
                                <h2>Governing Body</h2>
                                <div class="section-action">
                                    <NavLink :href="route('governing-body.list')" class="btn btn-primary">View All</NavLink>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="people">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="people-item">
                                <div class="people-img">
                                    <img src="@/assets/frontend/images/people.jpg" alt="">
                                </div>
                                <div class="people-caption">
                                    <h5>Mr. Robert Jones</h5>
                                    <p>Designation of the People</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="people-item">
                                <div class="people-img">
                                    <img src="@/assets/frontend/images/people.jpg" alt="">
                                </div>
                                <div class="people-caption">
                                    <h5>Mr. Robert Jones</h5>
                                    <p>Designation of the People</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="people-item">
                                <div class="people-img">
                                    <img src="@/assets/frontend/images/people.jpg" alt="">
                                </div>
                                <div class="people-caption">
                                    <h5>Mr. Robert Jones</h5>
                                    <p>Designation of the People</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="people-item">
                                <div class="people-img">
                                    <img src="@/assets/frontend/images/people.jpg" alt="">
                                </div>
                                <div class="people-caption">
                                    <h5>Mr. Robert Jones</h5>
                                    <p>Designation of the People</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="campus-video-section section-padding-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="campus-video video-popup"  data-fancybox="video-gallery" data-options="infinite:false" data-type="html5video" :data-src="'https://www.youtube.com/watch?v=_r58G5iM_NU'">
                            <div class="thumbnail" style="background-image: url('https://i.ytimg.com/vi/_r58G5iM_NU/hqdefault.jpg')"></div>
                            <div class="video-caption">
                                <span class="player-icon">
                                    <i class="bx bx-play-circle"></i>
                                </span>
                                <span class="title">Watch our campus life</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="why-us-section section-padding-60">
            <div class="section-title-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <h2>Our Facilities</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="why-us">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="why-choose-us-thumbnail">
                                <img src="@/assets/frontend/images/wh-img-1.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="why-us-item">
                                        <img src="@/assets/frontend/images/facility-img-1.jpg" alt="">
                                        <h3>Library</h3>
                                        <p>Lorem ipsum dolor sit. Lorem ipsum dolor.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="why-us-item">
                                        <img src="@/assets/frontend/images/facility-img-1.jpg" alt="">
                                        <h3>Computer Lab</h3>
                                        <p>Lorem ipsum dolor sit. Lorem ipsum dolor.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="why-us-item">
                                        <img src="@/assets/frontend/images/facility-img-1.jpg" alt="">
                                        <h3>Science Lab</h3>
                                        <p>Lorem ipsum dolor sit. Lorem ipsum dolor.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="why-us-item">
                                        <img src="@/assets/frontend/images/facility-img-1.jpg" alt="">
                                        <h3>Playground</h3>
                                        <p>Lorem ipsum dolor sit. Lorem ipsum dolor.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="why-us-item">
                                        <img src="@/assets/frontend/images/facility-img-1.jpg" alt="">
                                        <h3>Security</h3>
                                        <p>Lorem ipsum dolor sit. Lorem ipsum dolor.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="why-us-item">
                                        <img src="@/assets/frontend/images/facility-img-1.jpg" alt="">
                                        <h3>School Hostel</h3>
                                        <p>Lorem ipsum dolor sit. Lorem ipsum dolor.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <GalleryCarousel/>

        <section class="blog-section section-padding-60">
            <div class="section-title-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title text-center">
                                <h2>Latest News</h2>
                                <div class="section-action">
                                    <a href="" class="btn btn-primary">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="blogs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4" v-for="blog in 3" :key="blog">
                            <div class="blog-item">
                                <div class="blog-thumbnail">
                                    <img src="@/assets/frontend/images/photo-gallery-1.jpg" alt="">
                                </div>
                                <div class="blog-content">
                                    <span class="blog-category">Category name</span>
                                    <a href="#">
                                        <h3 class="title">How to write a blog</h3>
                                    </a>
                                    <p class="short-description">Lorem ipsum dolor adfa dsf sit amet, dfads fadsf asfa dsf asdf asdfasfa sdf consectetur adipisicing elit. Adipisci consequatur dignissimos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </AppLayout>
</template>

<style>

</style>
