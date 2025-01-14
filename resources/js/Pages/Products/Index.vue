<script setup>
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Create from "./Create.vue";

// Properti yang diterima dari parent
defineProps({
    products: Array,
    categories: Array,
    subCategories: Array,
});

// Fungsi untuk menghapus produk
const deleteProduct = async (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
        await Inertia.delete(route("products.destroy", id));
    }
};

// State untuk mengatur visibilitas modal
const isModalOpen = ref(false);

// Fungsi untuk membuka modal
const openModal = () => {
    isModalOpen.value = true;
};

// Fungsi untuk menutup modal
const closeModal = () => {
    isModalOpen.value = false;
};
</script>

<template>
    <section>
        <Head title="Products" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Daftar Produk
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div class="mb-4">
                                <!-- Button to open modal -->
                                <button
                                    @click="openModal"
                                    class="bg-blue-500 text-white px-4 py-2 rounded"
                                >
                                    Tambah Produk
                                </button>

                                <!-- Modal component -->
                                <Create
                                    v-if="isModalOpen"
                                    :categories="categories"
                                    :subCategories="subCategories"
                                    @close="closeModal"
                                />
                            </div>

                            <!-- Table of products -->
                            <table class="w-full table-auto">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border">Nama</th>
                                        <th class="px-4 py-2 border">
                                            Kategori
                                        </th>
                                        <th class="px-4 py-2 border">
                                            Subkategori
                                        </th>
                                        <th class="px-4 py-2 border">Harga</th>
                                        <th class="px-4 py-2 border">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="product in products"
                                        :key="product.id"
                                    >
                                        <td class="px-4 py-2 border">
                                            {{ product.name }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{
                                                product.category
                                                    ? product.category.name
                                                    : "No Category"
                                            }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{
                                                product.sub_category
                                                    ? product.sub_category.name
                                                    : "No Subcategory"
                                            }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{ product.price }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'products.show',
                                                        product.id,
                                                    )
                                                "
                                                class="bg-green-500 text-white px-4 py-2 rounded"
                                                >Lihat</inertia-link
                                            >
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'products.edit',
                                                        product.id,
                                                    )
                                                "
                                                class="bg-yellow-500 text-white px-4 py-2 rounded"
                                                >Edit</inertia-link
                                            >
                                            <button
                                                @click="
                                                    deleteProduct(product.id)
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
