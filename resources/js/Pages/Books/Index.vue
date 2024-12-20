<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Books"> </Head>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Buku</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="mb-4">
              <!-- Menggunakan Link dari Inertia untuk navigasi -->
              <inertia-link :href="route('books.create')" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Buku</inertia-link>
            </div>

            <table class="w-full">
              <thead>
                <tr>
                  <th class="px-4 py-2 border">Judul</th>
                  <th class="px-4 py-2 border">Penulis</th>
                  <th class="px-4 py-2 border">Deskripsi</th>
                  <th class="px-4 py-2 border">Gambar</th>
                  <th class="px-4 py-2 border">Video</th>
                  <th class="px-4 py-2 border">Suara</th>
                  <th class="px-4 py-2 border">Aksi</th>
                </tr>
              </thead>

              <tbody>
                <!-- Loop untuk menampilkan buku-buku -->
                <tr v-for="book in books" :key="book.id">
                  <td class="px-4 py-2 border">{{ book.title }}</td>
                  <td class="px-4 py-2 border">{{ book.author }}</td>
                  <td class="px-4 py-2 border">{{ book.description }}</td>

                  <!-- Menampilkan Gambar -->
                  <td class="px-4 py-2 border">
                    <img v-if="book.image_path" :src="`/storage/${book.image_path}`" alt="Book Image" class="max-w-xs h-auto">
                  </td>

                  <!-- Menampilkan Video -->
                  <td class="px-4 py-2 border">
                    <video v-if="book.video_path" controls class="max-w-xs">
                      <source :src="`/storage/${book.video_path}`" type="video/mp4">
                      Your browser does not support the video tag.
                    </video>
                  </td>

                  <!-- Menampilkan Audio -->
                  <td class="px-4 py-2 border">
                    <audio v-if="book.audio_path" controls class="max-w-xs">
                      <source :src="`/storage/${book.audio_path}`" type="audio/mpeg">
                      Your browser does not support the audio element.
                    </audio>
                  </td>

                  <td class="px-4 py-2 border">
                    <!-- Edit menggunakan Link -->
                    <inertia-link :href="route('books.edit', book.id)" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</inertia-link>

                    <!-- Tombol untuk menghapus menggunakan Inertia -->
                    <button @click="deleteBook(book.id)" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
// Import Inertia dari 'inertiajs/inertia'
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    books: Array, // Perbaiki tipe data menjadi Array
  },
  methods: {
    // Fungsi untuk menghapus buku
    deleteBook(bookId) {
      if (confirm('Apakah Anda yakin ingin menghapus buku ini?')) {
        console.log(`Deleting book with ID: ${bookId}`);
        // Make sure the route function is available and working correctly
        Inertia.delete(window.route('books.destroy', bookId));
      }
    },
  },
};
</script>
