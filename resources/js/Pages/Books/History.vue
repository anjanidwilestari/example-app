<script setup>
import { defineProps, ref, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    book: Object,
    audits: Array,
});

const expanded = ref(null);

const getTitle = (event) => {
    if (event === "created") return "Buku ditambahkan";
    if (event === "updated") return "Buku diperbarui";
    if (event === "deleted") return "Buku dihapus";
    return "Perubahan";
};

// Mendapatkan warna berdasarkan event
const getColor = (event) => {
    if (event === "created") return "text-green-600"; // Hijau
    if (event === "updated") return "text-yellow-600"; // Kuning
    if (event === "deleted") return "text-red-600"; // Merah
    return "text-gray-600";
};

// Format tanggal & waktu (dd/MM/yy hh:mm AM/PM)
const formatDate = (dateStr) => {
    const options = {
        day: "2-digit",
        month: "2-digit",
        year: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    };
    return new Date(dateStr).toLocaleString("id-ID", options);
};

// Urutkan audit dari terbaru ke terlama
const sortedAudits = computed(() => {
    return [...props.audits].sort(
        (a, b) => new Date(b.created_at) - new Date(a.created_at),
    );
});
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="w-64 h-64 mx-auto bg-white shadow rounded-lg p-4 overflow-hidden"
        >
            <h2 class="text-sm font-semibold text-gray-800 mb-2">
                Riwayat - {{ book.title }}
            </h2>

            <div class="h-48 overflow-y-auto no-scrollbar space-y-2">
                <ul v-if="sortedAudits.length" class="text-xs text-gray-700">
                    <li
                        v-for="audit in sortedAudits"
                        :key="audit.id"
                        class="p-2 border-b"
                    >
                        <!-- Baris 1: Judul Aktivitas dengan Warna -->
                        <p :class="['font-semibold', getColor(audit.event)]">
                            {{ getTitle(audit.event) }}
                        </p>
                        <!-- Baris 2: Tanggal & Waktu -->
                        <p class="text-gray-500">
                            {{ formatDate(audit.created_at) }}
                        </p>
                        <!-- Baris 3: Nama User -->
                        <p class="text-gray-500">
                            Oleh {{ audit.user ? audit.user.name : "Anonim" }}
                        </p>

                        <!-- Tombol Lihat Perubahan -->
                        <button
                            class="text-sm text-blue-500 hover:underline mt-1"
                            @click="
                                expanded =
                                    expanded === audit.id ? null : audit.id
                            "
                        >
                            Lihat selengkapnya
                        </button>

                        <!-- Detail Perubahan (Hanya tampil jika diklik) -->
                        <div
                            v-if="expanded === audit.id"
                            class="mt-1 p-2 bg-gray-100 rounded"
                        >
                            <ul class="ml-2 text-xs text-gray-600">
                                <li
                                    v-for="(change, key) in audit.old_values"
                                    :key="key"
                                >
                                    <strong>{{ key }}</strong
                                    >:
                                    <span class="text-red-500">{{
                                        change
                                    }}</span>
                                    →
                                    <span class="text-green-500">{{
                                        audit.new_values[key]
                                    }}</span>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <p v-else class="text-gray-400 text-sm">
                    Tidak ada riwayat perubahan.
                </p>
            </div>

            <inertia-link
                :href="route('books.index')"
                class="block mt-3 bg-blue-500 text-white text-center text-sm py-1 rounded"
            >
                Kembali
            </inertia-link>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
