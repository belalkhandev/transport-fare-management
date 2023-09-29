<script setup>
import {Link, useForm} from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    as: String,
});

const form = useForm({});

const submit = () => {
    form.post(props.href);
};

</script>

<template>
    <div>
        <form v-if="as === 'button'" @submit.prevent="submit">
            <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                <slot />
            </button>
        </form>

        <a v-else-if="as ==='a'" :href="href" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            <slot />
        </a>

        <Link v-else :href="href" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            <slot />
        </Link>
    </div>
</template>
