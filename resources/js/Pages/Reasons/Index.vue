<script setup>
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
</script>

<template>
    <section>
        <Head title="Reasons"> </Head>
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Daftar Reasons
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div class="mb-4">
                                <!-- Menggunakan Link dari Inertia untuk navigasi -->
                                <inertia-link
                                    :href="route('reasons.create')"
                                    class="bg-blue-500 text-white px-4 py-2 rounded"
                                    >Tambah Testimoni</inertia-link
                                >
                            </div>

                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border">Icon</th>
                                        <th class="px-4 py-2 border">Judul</th>
                                        <th class="px-4 py-2 border">
                                            Deskripsi
                                        </th>
                                        <th class="px-4 py-2 border">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <!-- Loop untuk menampilkan reason -->
                                    <tr
                                        v-for="reason in reasons"
                                        :key="reason.id"
                                    >
                                        <!-- Menampilkan Icon -->
                                        <td class="px-4 py-2 border">
                                            <img
                                                v-if="reason.icon"
                                                :src="`/storage/icons/${reason.icon}`"
                                                alt="Icon-Reason"
                                                class="media-thumbnail"
                                            />
                                            <p
                                                v-else
                                                class="w-10 h-10 rounded-full bg-gray-300"
                                            ></p>
                                            <!-- Placeholder jika tidak ada foto -->
                                        </td>

                                        <!-- Judul -->
                                        <td class="px-4 py-2 border">
                                            {{ reason.title }}
                                        </td>

                                        <!-- Deskripsi -->
                                        <td class="px-4 py-2 border">
                                            {{
                                                truncateDescription(
                                                    reason.description,
                                                )
                                            }}
                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-4 py-2 border">
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'reasons.edit',
                                                        reason.id,
                                                    )
                                                "
                                                class="bg-yellow-500 text-white px-4 py-2 rounded"
                                                >Edit</inertia-link
                                            >
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'reasons.show',
                                                        reason.id,
                                                    )
                                                "
                                                class="bg-green-500 text-white px-4 py-2 rounded"
                                                >Show</inertia-link
                                            >
                                            <button
                                                @click="deleteReason(reason.id)"
                                                class="bg-red-500 text-white px-4 py-2 rounded"
                                            >
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        reasons: Array, // Menerima data reason dari Inertia
    },
    methods: {
        // Fungsi untuk menghapus reason
        deleteReason(reasonId) {
            if (confirm("Apakah Anda yakin ingin menghapus reason ini?")) {
                Inertia.delete(window.route("reasons.destroy", reasonId));
            }
        },

        // Fungsi untuk memotong review menjadi 50 karakter dan menambahkan titik-titik
        truncateDescription(description) {
            if (description) {
                if (description.length > 50) {
                    return description.slice(0, 50) + "..."; // Gabungkan 50 karakter pertama dan tambahkan titik-titik
                }
                return description;
            }
            return ""; // Jika tidak ada review
        },
    },
};
</script>

<style scoped>
/* Styling untuk gambar dengan rasio 1:1 */
.media-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #ddd; /* Menambahkan border */
}
</style>
