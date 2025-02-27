<script setup>
import { ref, computed, defineProps } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    audits: {
        type: Array,
        default: () => [],
    },
});

// State untuk pencarian dan filter
const searchQuery = ref("");
const selectedEvent = ref(""); // Filter event

// Fungsi untuk memformat tanggal
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleString("id-ID", {
        dateStyle: "long",
        timeStyle: "short",
    });
};

// Filter hasil berdasarkan input pencarian (ID/User) dan event yang dipilih
const filteredAudits = computed(() => {
    return props.audits.filter((audit) => {
        const matchesSearch =
            audit.auditable_id.toString().includes(searchQuery.value) ||
            (audit.user?.name || "")
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase());

        const matchesEvent = selectedEvent.value
            ? audit.event === selectedEvent.value
            : true;

        return matchesSearch && matchesEvent;
    });
});
</script>

<template>
    <section>
        <AuthenticatedLayout>
            <template #header>
                <div class="flex justify-between items-center w-full">
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Daftar Buku
                    </h2>
                </div>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="p-6 bg-white rounded-lg shadow">
                        <div class="flex gap-2 justify-between">
                            <h2 class="text-2xl font-bold mb-4">
                                Riwayat Perubahan Buku
                            </h2>
                            <div class="flex space-x-2">
                                <!-- Input Pencarian ID dan User -->
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari berdasarkan ID / User..."
                                    class="border px-3 py-2 rounded-lg text-sm w-72"
                                />

                                <!-- Dropdown Filter Event -->
                                <select
                                    v-model="selectedEvent"
                                    class="border px-3 py-2 rounded-lg text-sm"
                                >
                                    <option value="">Semua Event</option>
                                    <option value="created">Dibuat</option>
                                    <option value="updated">Diperbarui</option>
                                    <option value="deleted">Dihapus</option>
                                </select>
                            </div>
                        </div>

                        <div v-if="filteredAudits.length" class="space-y-4">
                            <div
                                v-for="audit in filteredAudits"
                                :key="audit.id"
                                class="p-4 border rounded-lg shadow-sm bg-gray-50"
                            >
                                <div class="flex justify-between items-center">
                                    <h2 class="text-lg font-semibold">
                                        <span class="text-gray-600"
                                            >Buku ID:</span
                                        >
                                        {{ audit.auditable_id }}
                                    </h2>
                                    <span
                                        class="px-3 py-1 rounded-full text-white text-sm"
                                        :class="{
                                            'bg-blue-500':
                                                audit.event === 'created',
                                            'bg-yellow-500':
                                                audit.event === 'updated',
                                            'bg-red-500':
                                                audit.event === 'deleted',
                                        }"
                                    >
                                        {{
                                            audit.event === "created"
                                                ? "Dibuat"
                                                : audit.event === "updated"
                                                  ? "Diperbarui"
                                                  : "Dihapus"
                                        }}
                                    </span>
                                </div>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ formatDate(audit.created_at) }}
                                </p>

                                <div class="mt-2">
                                    <p class="text-gray-700">
                                        <strong>Pengguna:</strong>
                                        {{
                                            audit.user
                                                ? audit.user.name
                                                : "Tidak diketahui"
                                        }}
                                    </p>
                                </div>

                                <div
                                    v-if="audit.event === 'updated'"
                                    class="mt-3 text-sm"
                                >
                                    <p class="text-gray-600 font-medium">
                                        Perubahan:
                                    </p>
                                    <ul class="mt-1 space-y-1">
                                        <li
                                            v-for="(
                                                value, key
                                            ) in audit.new_values"
                                            :key="key"
                                            class="bg-gray-200 p-2 rounded"
                                        >
                                            <strong class="text-gray-700"
                                                >{{ key }}:</strong
                                            >
                                            <span class="text-red-500">
                                                {{
                                                    audit.old_values[key] ??
                                                    "Tidak ada"
                                                }}
                                            </span>
                                            →
                                            <span class="text-green-600">{{
                                                value
                                            }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <p
                                    v-if="audit.event === 'deleted'"
                                    class="text-gray-500 italic mt-2"
                                >
                                    Data buku ini telah dihapus.
                                </p>
                            </div>
                        </div>

                        <p v-else class="text-gray-500 text-center mt-4">
                            Tidak ada riwayat perubahan yang cocok dengan
                            pencarian atau filter event.
                        </p>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
