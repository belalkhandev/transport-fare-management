<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="btn btn-sm btn-outline-danger">
        <slot />
    </button>
</template>
