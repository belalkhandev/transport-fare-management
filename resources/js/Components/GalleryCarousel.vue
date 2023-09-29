<script>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide } from "vue3-carousel";
import { defineComponent } from "vue";

export default defineComponent({
    name: 'MessageSlider',
    components: {
        Carousel,
        Slide
    },
})

</script>

<template>
    <section class="photo-gallery-section section-padding-50">
        <Carousel class="photo-galleries"  :autoplay="5000" :transition="1000" snap-align="center" :wrap-around="true" :items-to-show="4">
            <Slide v-for="slide in 10" :key="slide">
                <div class="photo-item">
                    <a href="">
                        <img src="@/assets/frontend/images/photo-gallery-1.jpg" alt="">
                    </a>
                </div>
            </Slide>
        </Carousel>

        <div class="photo-gallery-explore">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="explore">
                            <h2>Explore Our School Photo Gallery</h2>
                            <a href="" class="btn btn-light">View Gallery</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
    .photo-item {
        margin: 0 5px;
    }
</style>
