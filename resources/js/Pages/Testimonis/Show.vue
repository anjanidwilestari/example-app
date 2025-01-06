<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Menerima data props yang dikirim dari controller (hanya data untuk menampilkan)
const props = defineProps({
    testimoni: Object,
});
</script>

<template>
    <section>
        <Head title="Detail Testimoni" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail Testimoni
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <!-- Nama Konsumen -->
                        <div class="mb-4">
                            <strong>Nama Konsumen:</strong>
                            {{ props.testimoni.name_customer }}
                        </div>

                        <!-- Tempat Kerja -->
                        <div class="mb-4">
                            <strong>Tempat Kerja:</strong>
                            {{ props.testimoni.workplace }}
                        </div>

                        <!-- Review -->
                        <div class="mb-4">
                            <strong>Review:</strong>
                            <p>{{ props.testimoni.review }}</p>
                        </div>

                        <!-- Foto -->
                        <div class="mb-4">
                            <strong>Foto:</strong>
                            <img
                                v-if="props.testimoni.photo"
                                :src="`/storage/photos/${props.testimoni.photo}`"
                                alt="Foto Testimoni"
                                class="w-32 h-32 object-cover rounded"
                            />
                            <p v-else class="text-gray-500">Tidak ada foto</p>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <strong>Status:</strong>
                            <span
                                :class="
                                    props.testimoni.status
                                        ? 'text-green-600'
                                        : 'text-red-600'
                                "
                            >
                                {{
                                    props.testimoni.status
                                        ? "Aktif"
                                        : "Non-Aktif"
                                }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
