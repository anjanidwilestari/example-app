<script setup>
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Props
defineProps({
    features: Array, // Menerima data fitur produk dari Inertia
});

// Methods
const deleteFeature = (featureId) => {
    if (confirm("Apakah Anda yakin ingin menghapus fitur produk ini?")) {
        Inertia.delete(window.route("product_features.destroy", featureId));
    }
};

const truncateDescription = (description) => {
    if (description) {
        if (description.length > 50) {
            return description.slice(0, 50) + "...";
        }
        return description;
    }
    return "";
};
</script>

<template>
    <section>
        <Head title="Product Features"> </Head>
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Daftar Fitur Produk
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div class="mb-4">
                                <inertia-link
                                    :href="route('product_features.create')"
                                    class="bg-blue-500 text-white px-4 py-2 rounded"
                                    >Tambah Fitur Produk</inertia-link
                                >
                            </div>

                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border">
                                            Nama Fitur
                                        </th>
                                        <th class="px-4 py-2 border">
                                            Deskripsi
                                        </th>
                                        <th class="px-4 py-2 border">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="feature in features"
                                        :key="feature.id"
                                    >
                                        <td class="px-4 py-2 border">
                                            {{ feature.feature }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{
                                                truncateDescription(
                                                    feature.description,
                                                )
                                            }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'product_features.show',
                                                        feature.id,
                                                    )
                                                "
                                                class="bg-green-500 text-white px-4 py-2 rounded"
                                            >
                                                Lihat
                                            </inertia-link>
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'product_features.edit',
                                                        feature.id,
                                                    )
                                                "
                                                class="bg-yellow-500 text-white px-4 py-2 rounded"
                                            >
                                                Edit
                                            </inertia-link>
                                            <button
                                                @click="
                                                    deleteFeature(feature.id)
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
