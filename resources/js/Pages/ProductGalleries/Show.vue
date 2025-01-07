<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Props
const props = defineProps({
    gallery: Object, // Single product gallery image
});
</script>

<template>
    <section>
        <Head title="Gallery Image Details" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Gallery Image Details
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="mb-4">
                            <strong>Product:</strong>
                            {{ props.gallery.product.name }}
                        </div>

                        <div class="mb-4">
                            <strong>Image:</strong>
                            <img
                                :src="
                                    route(
                                        'product_galleries.show',
                                        props.gallery.id,
                                    )
                                "
                                alt="Product Gallery Image"
                                class="max-w-xs mt-2"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
