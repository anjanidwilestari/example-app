<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Menerima data props yang dikirim dari controller (data untuk menampilkan kategori produk)
const props = defineProps({
    category: Object,
});
</script>

<template>
    <section>
        <Head title="Detail Product Category" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail Product Category
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <!-- Name -->
                        <div class="mb-4">
                            <strong>Category Name:</strong>
                            {{ props.category.name }}
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <strong>Description:</strong>
                            <p>{{ props.category.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
