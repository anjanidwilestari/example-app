<script setup>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    bookId: Number,
});

const audits = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchAudits = async () => {
    try {
        const response = await fetch(`/books/${props.bookId}/audits`);
        if (!response.ok) throw new Error("Gagal mengambil audit data.");
        audits.value = await response.json();
    } catch (err) {
        error.value = err.message;
    } finally {
        loading.value = false;
    }
};

onMounted(fetchAudits);
</script>

<template>
    <div class="p-4 bg-white shadow rounded-lg">
        <h2 class="text-xl font-bold mb-4">Riwayat Perubahan</h2>

        <div v-if="loading" class="text-gray-500">Memuat audit...</div>
        <div v-else-if="error" class="text-red-500">{{ error }}</div>
        <div v-else-if="audits.length === 0" class="text-gray-500">
            Tidak ada audit ditemukan.
        </div>

        <ul v-else class="divide-y divide-gray-200">
            <li v-for="audit in audits" :key="audit.id" class="py-3">
                <p class="text-sm text-gray-600">
                    <strong>{{ audit.audit_event }}</strong> oleh
                    <span v-if="audit.user">{{ audit.user.name }}</span>
                    <span v-else class="italic">User Tidak Diketahui</span>
                    pada {{ new Date(audit.created_at).toLocaleString() }}
                </p>

                <ul class="mt-2 text-sm text-gray-500">
                    <li v-for="(change, key) in audit.old_values" :key="key">
                        <strong>{{ key }}</strong
                        >: <span class="text-red-500">{{ change }}</span> →
                        <span class="text-green-500">{{
                            audit.new_values[key]
                        }}</span>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>
