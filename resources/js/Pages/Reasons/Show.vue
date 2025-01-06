<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Menerima data props yang dikirim dari controller (hanya data untuk menampilkan)
const props = defineProps({
    reason: Object,
});
</script>

<template>
    <section>
        <Head title="Detail Reason" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail Reason
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <!-- Judul -->
                        <div class="mb-4">
                            <strong>Judul:</strong> {{ props.reason.title }}
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <strong>Deskripsi:</strong>
                            <p>{{ props.reason.description }}</p>
                        </div>

                        <!-- Icon -->
                        <div class="mb-4">
                            <strong>Icon:</strong>
                            <img
                                v-if="props.reason.icon"
                                :src="`/storage/icons/${props.reason.icon}`"
                                alt="Icon Reason"
                                class="w-32 h-32 object-cover rounded"
                            />
                            <p v-else class="text-gray-500">Tidak ada icon</p>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
