<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Mendeklarasikan props yang diterima oleh komponen
defineProps({
    footers: Array,
});

// Reactive state
const showCreateFooterModal = ref(false);
const newFooterName = ref("");

// Fungsi untuk membuat footer
const createFooter = () => {
    Inertia.post("/footers", { name: newFooterName.value });
    showCreateFooterModal.value = false;
    newFooterName.value = "";
};

// Fungsi untuk menghapus footer
const deleteFooter = (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus footer ini?")) {
        Inertia.delete(`/footers/${id}`);
    }
};

// Fungsi untuk mengedit footer
const editFooter = (footer) => {
    const newName = prompt("Edit Footer Name:", footer.name);
    if (newName) {
        Inertia.put(`/footers/${footer.id}`, { name: newName });
    }
};

// Fungsi untuk menambah sub-footer
const addSubFooter = (footerId) => {
    const name = prompt("Enter Sub Footer Name:");
    const link = prompt("Enter Link:");
    Inertia.post(`/footers/${footerId}/sub-footers`, { name, link });
};

// Fungsi untuk mengedit sub-footer
const editSubFooter = (subFooter) => {
    const newName = prompt("Edit Sub Footer Name:", subFooter.name);
    const newLink = prompt("Edit Sub Footer Link:", subFooter.link);
    if (newName && newLink) {
        Inertia.put(`/sub-footers/${subFooter.id}`, {
            name: newName,
            link: newLink,
        });
    }
};

// Fungsi untuk menghapus sub-footer
const deleteSubFooter = (id) => {
    if (confirm("Are you sure you want to delete this subfooter?")) {
        Inertia.delete(`/sub-footers/${id}`);
    }
};
</script>

<template>
    <section>
        <Head title="Footers" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Daftar Footer
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <!-- Tombol untuk menambah Footer -->
                            <div class="mb-4">
                                <button
                                    @click="showCreateFooterModal = true"
                                    class="bg-blue-500 text-white px-4 py-2 rounded"
                                >
                                    Tambah Footer
                                </button>
                            </div>

                            <!-- Modal untuk menambah Footer -->
                            <div v-if="showCreateFooterModal" class="modal">
                                <input
                                    v-model="newFooterName"
                                    placeholder="Footer Name"
                                    class="border p-2 mb-4 w-full"
                                />
                                <div>
                                    <button
                                        @click="createFooter"
                                        class="bg-green-500 text-white px-4 py-2 rounded mr-2"
                                    >
                                        Create Footer
                                    </button>
                                    <button
                                        @click="showCreateFooterModal = false"
                                        class="bg-gray-500 text-white px-4 py-2 rounded"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </div>

                            <!-- Tabel Daftar Footers -->
                            <table class="w-full table-auto mt-6">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th
                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-white"
                                        >
                                            Footer Name
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-white"
                                        >
                                            Actions
                                        </th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-white"
                                        >
                                            Sub Footers
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="footer in footers"
                                        :key="footer.id"
                                    >
                                        <td class="px-4 py-2 border">
                                            {{ footer.name }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <button
                                                @click="editFooter(footer)"
                                                class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                @click="deleteFooter(footer.id)"
                                                class="bg-red-500 text-white px-4 py-2 rounded ml-2 hover:bg-red-600"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <!-- Tabel Sub Footers -->
                                            <table
                                                class="w-full mt-4 table-auto"
                                            >
                                                <thead
                                                    class="bg-gray-200 dark:bg-gray-700"
                                                >
                                                    <tr>
                                                        <th
                                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-white"
                                                        >
                                                            Sub Footer Name
                                                        </th>
                                                        <th
                                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-white"
                                                        >
                                                            Link
                                                        </th>
                                                        <th
                                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-white"
                                                        >
                                                            Actions
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="subFooter in footer.sub_footers"
                                                        :key="subFooter.id"
                                                    >
                                                        <td
                                                            class="px-4 py-2 border"
                                                        >
                                                            {{ subFooter.name }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-2 border"
                                                        >
                                                            <a
                                                                :href="
                                                                    subFooter.link.startsWith(
                                                                        'http',
                                                                    )
                                                                        ? subFooter.link
                                                                        : 'http://' +
                                                                          subFooter.link
                                                                "
                                                                target="_blank"
                                                                class="text-blue-600 hover:text-blue-800"
                                                            >
                                                                Link
                                                            </a>
                                                        </td>
                                                        <td
                                                            class="px-4 py-2 border"
                                                        >
                                                            <button
                                                                @click="
                                                                    editSubFooter(
                                                                        subFooter,
                                                                    )
                                                                "
                                                                class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600"
                                                            >
                                                                Edit
                                                            </button>
                                                            <button
                                                                @click="
                                                                    deleteSubFooter(
                                                                        subFooter.id,
                                                                    )
                                                                "
                                                                class="bg-red-500 text-white px-4 py-2 rounded ml-2 hover:bg-red-600"
                                                            >
                                                                Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!-- Tombol untuk menambah Sub Footer -->
                                            <button
                                                @click="addSubFooter(footer.id)"
                                                class="mt-4 px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                                            >
                                                Add Sub Footer
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
/* Modal styling */
.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border: 1px solid #ccc;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}
</style>
