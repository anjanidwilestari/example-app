<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    subCategory: Object,
});
</script>

<template>
    <section>
        <Head title="Product Subcategory Details" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Product Subcategory Details
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <!-- Subcategory Name -->
                        <div class="mb-4">
                            <strong>Subcategory Name:</strong>
                            {{ props.subCategory.name }}
                        </div>

                        <!-- Subcategory Description -->
                        <div class="mb-4">
                            <strong>Description:</strong>
                            <p>{{ props.subCategory.description }}</p>
                        </div>

                        <!-- Category Name -->
                        <div class="mb-4">
                            <strong>Category:</strong>
                            <p>{{ props.subCategory.category.name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
