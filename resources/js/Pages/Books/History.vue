<script setup>
import { defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    book: Object,
    audits: Array,
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Riwayat Perubahan - {{ book.title }}
            </h2>
        </template>

        <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Log Perubahan</h2>

            <ul v-if="audits.length" class="divide-y divide-gray-300">
                <li v-for="audit in audits" :key="audit.id" class="py-3">
                    <p class="text-sm text-gray-600">
                        <strong>{{ audit.audit_event }}</strong> oleh
                        <span v-if="audit.user">{{ audit.user.name }}</span>
                        <span v-else class="italic">User Tidak Diketahui</span>
                        pada {{ new Date(audit.created_at).toLocaleString() }}
                    </p>

                    <ul class="mt-2 text-sm text-gray-500">
                        <li
                            v-for="(change, key) in audit.old_values"
                            :key="key"
                        >
                            <strong>{{ key }}</strong
                            >: <span class="text-red-500">{{ change }}</span> →
                            <span class="text-green-500">{{
                                audit.new_values[key]
                            }}</span>
                        </li>
                    </ul>
                </li>
            </ul>

            <p v-else class="text-gray-500">
                Tidak ada riwayat perubahan untuk buku ini.
            </p>

            <inertia-link
                :href="route('books.index')"
                class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded"
            >
                Kembali ke Daftar Buku
            </inertia-link>
        </div>
    </AuthenticatedLayout>
</template>
