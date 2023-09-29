<script>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import { defineComponent } from "vue";

export default defineComponent({
    name: 'Basic',
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
})

</script>

<template>
    <div class="slider-section">

        <Carousel :autoplay="500000" :transition="1000" :wrap-around="true" :items-to-show="1">
            <Slide :key="1">
                <div class="slide-item">
                    <div class="slide-img">
                        <img src="@/assets/frontend/images/slider-bg-1.jpg" alt="">
                    </div>
                    <div class="slide-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <h5>Lorem ipsum dolor sit amet, consectetur adipisicing.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Slide>
            <Slide :key="2">
                <div class="slide-item">
                    <div class="slide-img">
                        <img src="@/assets/frontend/images/slider-bg-1.jpg" alt="">
                    </div>
                    <div class="slide-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <h5>Lorem ipsum dolor sit amet, consectetur adipisicing.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Slide>

            <template #addons>
                <Navigation />
                <Pagination />
            </template>
        </Carousel>


    </div>
</template>

<style scoped>


</style>
