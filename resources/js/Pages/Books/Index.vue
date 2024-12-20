<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
</script>

<template>
  <section>
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
                  
                  <!-- Menampilkan Deskripsi Terpotong -->
                  <td class="px-4 py-2 border">{{ truncateDescription(book.description) }}</td>

                  <!-- Menampilkan Gambar -->
                  <td class="px-4 py-2 border">
                    <img v-if="book.image_path" :src="`/storage/${book.image_path}`" alt="Book Image" class="media-thumbnail">
                  </td>

                  <!-- Menampilkan Video -->
                  <td class="px-4 py-2 border">
                    <video v-if="book.video_path" controls class="media-thumbnail">
                      <source :src="`/storage/${book.video_path}`" type="video/mp4">
                      Your browser does not support the video tag.
                    </video>
                  </td>

                  <!-- Menampilkan Audio -->
                  <td class="px-4 py-2 border">
                    <audio v-if="book.audio_path" controls class="media-thumbnail">
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
  </section>
  
  
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    books: Array,
  },
  methods: {
    // Fungsi untuk menghapus buku
    deleteBook(bookId) {
      if (confirm('Apakah Anda yakin ingin menghapus buku ini?')) {
        Inertia.delete(window.route('books.destroy', bookId));
      }
    },

    // Fungsi untuk memotong deskripsi menjadi 5 karakter dan menambahkan titik-titik
    truncateDescription(description) {
      if (description) {
        if (description.length > 5) {
          return description.slice(0, 5) + '...';  // Gabungkan 5 karakter pertama dan tambahkan titik-titik
        }
        return description;
      }
      return '';  // Jika tidak ada deskripsi
    }
  },
};
</script>

<style scoped>
/* Styling untuk gambar, video, dan audio dengan rasio 1:1 */
.media-thumbnail {
  width: 50px;
  height: 50px;
  object-fit: cover;
  border-radius: 5px;
  border: 1px solid #ddd; /* Menambahkan border */
}
</style>
