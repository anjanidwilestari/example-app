<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? "flex items-center px-3 py-2 text-sm font-medium leading-5 text-gray-900 bg-indigo-100 rounded-md focus:outline-none focus:bg-indigo-200 transition duration-150 ease-in-out"
        : "flex items-center px-3 py-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-md focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out",
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
