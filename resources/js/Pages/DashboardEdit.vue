<template>
  <Head title="Edit Dashboard"></Head>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Tampilan</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">Pilih Buku untuk Ditampilkan</div>

          <!-- Dropdown Buku -->
          <select v-model="selectedBookId" @change="updateBook" class="p-2 border rounded">
            <option v-for="book in books" :key="book.id" :value="book.id">
              {{ book.title }} - {{ book.author }}
            </option>
          </select>

          <!-- Tombol Simpan -->
          <button
            type="button"
            @click="saveBook"
            class="text-white bg-gradient-to-b from-pink-100 via-pink-400 to-pink-500 hover:bg-gradient-to-r focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 shadow-lg shadow-pink-500/50 dark:shadow-lg dark:shadow-pink-800/80 font-medium rounded-lg text-sm px-6 py-3.5 text-center me-2 mb-2 mt-12"
          >
            Simpan Tampilan
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Mendapatkan data buku dari props yang diterima
const { books, currentBook } = usePage().props;

// Menyimpan ID buku yang dipilih, dan buat currentBook reaktif
const selectedBookId = ref(currentBook?.id || null);

// Fungsi untuk mengupdate buku yang dipilih
const updateBook = () => {
  const selectedBook = books.find(book => book.id === selectedBookId.value);
  currentBook.title = selectedBook.title;
  currentBook.author = selectedBook.author;
  currentBook.description = selectedBook.description;
  currentBook.image_path = selectedBook.image_path;
};

// Fungsi untuk menyimpan pilihan buku dan kembali ke halaman dashboard
const saveBook = () => {
  // Kirimkan ID buku yang dipilih ke backend untuk disimpan
  Inertia.post(route('saveSelectedBook'), { book_id: selectedBookId.value });
};
</script>
