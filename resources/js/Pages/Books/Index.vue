<script setup>
import { ref } from "vue"; // Importing ref from Vue
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Declare props received by the component
defineProps({
    books: Array,
});

// State for loading and search query
const isLoading = ref(true); // Use ref to create a reactive state for loading
const searchQuery = ref(""); // Use ref to create a reactive state for search query

// Function to delete a book
const deleteBook = (bookId) => {
    if (confirm("Apakah Anda yakin ingin menghapus buku ini?")) {
        Inertia.delete(window.route("books.destroy", bookId));
    }
};

// Function to truncate description
const truncateDescription = (description) => {
    if (description) {
        if (description.length > 5) {
            return description.slice(0, 5) + "...";
        }
        return description;
    }
    return "";
};

// Search function placeholder (you can modify this logic as needed)
const performSearch = (e) => {
    e.preventDefault();
    console.log("Search for:", searchQuery.value);
    // Implement search functionality here if needed
};
</script>

<template>
    <section>
        <Head title="Books"> </Head>
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Daftar Buku
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <!-- Search Bar and Button -->
                            <div
                                class="d-flex"
                                style="
                                    justify-content: flex-end;
                                    margin-bottom: 10px;
                                    margin-top: 0;
                                "
                            >
                                <form
                                    class="d-flex"
                                    role="search"
                                    @submit.prevent="performSearch"
                                >
                                    <input
                                        class="form-control ms-2 form-kecil"
                                        type="search"
                                        placeholder="Cari"
                                        aria-label="Search"
                                        v-model="searchQuery"
                                    />
                                </form>
                                <button
                                    type="button"
                                    class="btn btn-baru btn-kecil ms-3"
                                >
                                    <img
                                        src="/public/assets/circle-solid.svg"
                                        alt="Add Icon"
                                        style="
                                            width: 17px;
                                            height: 17px;
                                            margin-bottom: 2.5px;
                                            filter: invert(1);
                                            margin-left: -6px;
                                        "
                                    />
                                    Unduh
                                </button>
                            </div>
                            <inertia-link
                                :href="route('books.create')"
                                class="bg-blue-500 text-white px-4 py-2 rounded"
                                >Tambah Buku</inertia-link
                            >
                            <!-- Loading Spinner -->
                            <div id="loading" v-if="isLoading">
                                <div class="spinner"></div>
                            </div>

                            <!-- Book Table -->
                            <table
                                class="table-new"
                                style="
                                    text-align: center;
                                    height: 170px;
                                    margin-top: 5px;
                                    font-size: 14px;
                                "
                            >
                                <thead>
                                    <tr style="height: 40px">
                                        <th scope="col" style="width: 5%">
                                            No
                                        </th>
                                        <th scope="col" style="width: 25%">
                                            Judul
                                        </th>
                                        <th scope="col" style="width: 5%">
                                            Penulis
                                        </th>
                                        <th scope="col" style="width: 25%">
                                            Deskripsi
                                        </th>
                                        <th scope="col" style="width: 10%">
                                            Gambar
                                        </th>
                                        <th scope="col" style="width: 10%">
                                            Video
                                        </th>
                                        <th scope="col" style="width: 10%">
                                            Suara
                                        </th>
                                        <th scope="col" style="width: 10%">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="table-body">
                                    <tr v-if="books.length === 0">
                                        <td
                                            colspan="8"
                                            class="text-center"
                                            style="height: 45px"
                                        >
                                            Data Tidak Ditemukan
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="(book, index) in books"
                                        :key="book.id"
                                    >
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>{{ book.title }}</td>
                                        <td>{{ book.author }}</td>
                                        <td>
                                            {{
                                                truncateDescription(
                                                    book.description,
                                                )
                                            }}
                                        </td>
                                        <td>
                                            <img
                                                v-if="book.image_path"
                                                :src="`/storage/${book.image_path}`"
                                                alt="Book Image"
                                                class="media-thumbnail"
                                            />
                                        </td>
                                        <td>
                                            <video
                                                v-if="book.video_path"
                                                controls
                                                class="media-thumbnail"
                                            >
                                                <source
                                                    :src="`/storage/${book.video_path}`"
                                                    type="video/mp4"
                                                />
                                            </video>
                                        </td>
                                        <td>
                                            <audio
                                                v-if="book.audio_path"
                                                controls
                                                class="media-thumbnail"
                                            >
                                                <source
                                                    :src="`/storage/${book.audio_path}`"
                                                    type="audio/mpeg"
                                                />
                                            </audio>
                                        </td>
                                        <td>
                                            <inertia-link
                                                :href="
                                                    route('books.edit', book.id)
                                                "
                                                class="bg-yellow-500 text-white px-4 py-2 rounded"
                                                >Edit</inertia-link
                                            >
                                            <inertia-link
                                                :href="
                                                    route('books.show', book.id)
                                                "
                                                class="bg-green-500 text-white px-4 py-2 rounded"
                                                >Show</inertia-link
                                            >
                                            <button
                                                @click="deleteBook(book.id)"
                                                class="bg-red-500 text-white px-4 py-2 rounded"
                                            >
                                                Hapus
                                            </button>
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'books.history',
                                                        book.id,
                                                    )
                                                "
                                                class="bg-gray-500 text-white px-4 py-2 rounded"
                                            >
                                                Riwayat
                                            </inertia-link>
                                        </td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr style="height: 41px">
                                        <th
                                            colspan="2"
                                            style="font-weight: 300"
                                        >
                                            Showing 1 to 1 of 1 entries
                                        </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <nav
                                                aria-label="Page navigation example"
                                                class="pagination-custom"
                                            >
                                                <ul
                                                    class="pagination"
                                                    style="
                                                        padding-top: 5.5px;
                                                        padding-left: 25px;
                                                    "
                                                >
                                                    <li class="page-item">
                                                        <a
                                                            href="#"
                                                            aria-label="Previous"
                                                        >
                                                            <img
                                                                src="/public/assets/nav-arrow-left.svg"
                                                                alt="Previous"
                                                                aria-hidden="true"
                                                            />
                                                        </a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a
                                                            href="#"
                                                            aria-label="Next"
                                                        >
                                                            <img
                                                                src="/public/assets/nav-arrow-right.svg"
                                                                alt="Next"
                                                                aria-hidden="true"
                                                            />
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>

<style scoped>
/* Styling for the button */
.btn-baru {
    background-color: transparent;
    color: #6c6666;
    border: 2px solid #169ea8;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 16px;
    transition:
        background-color 0.3s,
        color 0.3s;
}

.btn-baru:hover {
    background-color: rgba(22, 158, 168, 0.1);
    color: white;
}

/* Table Styling */
.table-new {
    border-collapse: collapse;
    width: 100%;
}

.table-new thead th {
    background-color: #f2f2f2;
}

.table-new tbody tr:hover {
    background-color: #f9f9f9;
}

.pagination-custom {
    height: 40px;
}

.table-new tfoot th {
    background-color: #f2f2f2;
}

.table-new {
    border-top: none;
}

.media-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #ddd;
}
</style>
