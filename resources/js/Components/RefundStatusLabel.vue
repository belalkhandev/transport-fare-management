<script setup>
defineProps({
    status: {
        type: String,
        default: true,
    },
});
</script>

<template>
    <div class="status-label">
        <span v-if="status === 'pending'" class="bg-slate-50 border-1 border-slate-200 text-slate-600">Pending</span>
        <span v-else-if="status === 'completed'" class="bg-green-50 border-1 border-green-200 text-green-600">Completed</span>
    </div>
</template>

<style scoped>

</style>
