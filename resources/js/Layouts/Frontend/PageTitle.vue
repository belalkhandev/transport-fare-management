<script setup>

defineProps({
    title: {
        type: String,
        Default: "School"
    },
});

</script>

<template>
    <div class="page-title-section section-padding-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-content text-center">
                        <h3>{{ title }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
