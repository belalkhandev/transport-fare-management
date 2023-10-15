<script setup>
import { Link }  from '@inertiajs/vue3';

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <div v-if="data.links.length > 3" class="mt-4">
        <nav class="d-flex justify-between align-items-center">
            <small v-if="data.to > 0" class="highlighted-text">
                Showing {{ data.from }} to {{ data.to }} of {{ data.total }} data.
            </small>
            <ul class="pagination">
                <li v-for="(link, k) in data.links"
                    :key="k"
                    class="page-item">
                    <Link
                        class="page-link"
                        :class="{'active': link.active}"
                        :href="link.url ?? '#'"
                        v-html="link.label"
                    />
                </li>
            </ul>
        </nav>
    </div>
</template>
