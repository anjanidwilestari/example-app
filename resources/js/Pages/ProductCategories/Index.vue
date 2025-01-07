<script setup>
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Props
defineProps({
    categories: Array, // Menerima data kategori produk dari Inertia
});

// Methods
const deleteCategory = (categoryId) => {
    if (confirm("Apakah Anda yakin ingin menghapus kategori produk ini?")) {
        Inertia.delete(window.route("product_categories.destroy", categoryId));
    }
};

const truncateDescription = (description) => {
    if (description) {
        if (description.length > 50) {
            return description.slice(0, 50) + "..."; // Gabungkan 50 karakter pertama dan tambahkan titik-titik
        }
        return description;
    }
    return ""; // Jika tidak ada deskripsi
};
</script>

<template>
    <section>
        <Head title="Product Categories"> </Head>
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Daftar Kategori Produk
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
                                    :href="route('product_categories.create')"
                                    class="bg-blue-500 text-white px-4 py-2 rounded"
                                    >Tambah Kategori Produk</inertia-link
                                >
                            </div>

                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border">Nama</th>
                                        <th class="px-4 py-2 border">
                                            Deskripsi
                                        </th>
                                        <th class="px-4 py-2 border">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <!-- Loop untuk menampilkan kategori produk -->
                                    <tr
                                        v-for="category in categories"
                                        :key="category.id"
                                    >
                                        <!-- Nama Kategori -->
                                        <td class="px-4 py-2 border">
                                            {{ category.name }}
                                        </td>

                                        <!-- Deskripsi Kategori -->
                                        <td class="px-4 py-2 border">
                                            {{
                                                truncateDescription(
                                                    category.description,
                                                )
                                            }}
                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-4 py-2 border">
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'product_categories.edit',
                                                        category.id,
                                                    )
                                                "
                                                class="bg-yellow-500 text-white px-4 py-2 rounded"
                                                >Edit</inertia-link
                                            >
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'product_categories.show',
                                                        category.id,
                                                    )
                                                "
                                                class="bg-green-500 text-white px-4 py-2 rounded"
                                                >Show</inertia-link
                                            >
                                            <button
                                                @click="
                                                    deleteCategory(category.id)
                                                "
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
