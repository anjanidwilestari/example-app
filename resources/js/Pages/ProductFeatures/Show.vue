<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Props
const props = defineProps({
    feature: Object, // Single product feature
});
</script>

<template>
    <section>
        <Head title="Detail Product Feature" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail Product Feature
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <!-- Product Name -->
                        <div class="mb-4">
                            <strong>Product:</strong>
                            {{ props.feature.product.name }}
                            <!-- Should work now -->
                        </div>

                        <!-- Feature Name -->
                        <div class="mb-4">
                            <strong>Feature:</strong>
                            {{ props.feature.feature }}
                        </div>

                        <!-- Feature Description -->
                        <div class="mb-4">
                            <strong>Description:</strong>
                            <p>{{ props.feature.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
