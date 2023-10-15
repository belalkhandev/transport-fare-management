<script setup>
defineProps({
    is_active: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div class="status-label">
        <span v-if="is_active" class="active">Active</span>
        <span v-else class="in-active">Inactive</span>
    </div>
</template>

<style scoped>

</style>
