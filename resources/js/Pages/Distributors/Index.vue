<script setup>
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Properti yang diterima dari parent
defineProps({
    distributors: Array,
});

// Fungsi untuk menghapus distributor
const deleteDistributor = async (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus distributor ini?")) {
        await Inertia.delete(route("distributors.destroy", id));
    }
};
</script>

<template>
    <section>
        <Head title="Distributors" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Daftar Distributor
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div class="mb-4">
                                <!-- Link to add a new distributor -->
                                <inertia-link
                                    :href="route('distributors.create')"
                                    class="bg-blue-500 text-white px-4 py-2 rounded"
                                    >Tambah Distributor</inertia-link
                                >
                            </div>

                            <table class="w-full table-auto">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border">Nama</th>
                                        <th class="px-4 py-2 border">
                                            Provinsi
                                        </th>
                                        <th class="px-4 py-2 border">Pulau</th>
                                        <th class="px-4 py-2 border">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="distributor in distributors"
                                        :key="distributor.id"
                                    >
                                        <td class="px-4 py-2 border">
                                            {{ distributor.name }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{ distributor.province }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            {{ distributor.island }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'distributors.show',
                                                        distributor.id,
                                                    )
                                                "
                                                class="bg-green-500 text-white px-4 py-2 rounded"
                                                >Lihat</inertia-link
                                            >
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'distributors.edit',
                                                        distributor.id,
                                                    )
                                                "
                                                class="bg-yellow-500 text-white px-4 py-2 rounded"
                                                >Edit</inertia-link
                                            >
                                            <button
                                                @click="
                                                    deleteDistributor(
                                                        distributor.id,
                                                    )
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
