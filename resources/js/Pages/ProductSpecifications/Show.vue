<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    specification: Object, // Single product specification
});
</script>

<template>
    <section>
        <Head title="Product Specification Detail" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Product Specification Detail
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="mb-4">
                            <strong>Product:</strong>
                            {{ specification.product.name }}
                        </div>

                        <div class="mb-4">
                            <strong>Specification:</strong>
                            {{ specification.specification }}
                        </div>

                        <div class="mb-4">
                            <strong>Description:</strong>
                            <p>{{ specification.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
