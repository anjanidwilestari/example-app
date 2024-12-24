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
    <Head title="Testimonis"> </Head>
    <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Testimoni</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="mb-4">
              <!-- Menggunakan Link dari Inertia untuk navigasi -->
              <inertia-link :href="route('testimonis.create')" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Testimoni</inertia-link>
            </div>

            <table class="w-full">
              <thead>
                <tr>
                  <th class="px-4 py-2 border">Foto</th>
                  <th class="px-4 py-2 border">Nama</th>
                  <th class="px-4 py-2 border">Tempat Kerja</th>
                  <th class="px-4 py-2 border">Review</th>
                  <th class="px-4 py-2 border">Status</th>
                  <th class="px-4 py-2 border">Aksi</th>
                </tr>
              </thead>

              <tbody>
                <!-- Loop untuk menampilkan testimoni -->
                <tr v-for="testimoni in testimonis" :key="testimoni.id">
                  <!-- Menampilkan Gambar -->
                  <td class="px-4 py-2 border">
                    <img v-if="testimoni.photo" :src="`/storage/photos/${testimoni.photo}`" alt="Foto Profile" class="media-thumbnail">
                    <p v-else class="w-10 h-10 rounded-full bg-gray-300"></p> <!-- Placeholder jika tidak ada foto -->
                  </td>

                  <!-- Nama Konsumen -->
                  <td class="px-4 py-2 border">{{ testimoni.name_customer }}</td>

                  <!-- Tempat Kerja -->
                  <td class="px-4 py-2 border">{{ testimoni.workplace }}</td>

                  <!-- Review -->
                  <td class="px-4 py-2 border">{{ truncateReview(testimoni.review) }}</td>

                  <!-- Status -->
                  <td class="px-4 py-2 border">
                    <div v-if="testimoni.status" class="bg-green-500 text-white rounded-md px-3 py-1 text-xs">
                      Aktif
                    </div>
                    <div v-else class="bg-gray-400 text-white rounded-md px-3 py-1 text-xs">
                      Non-Aktif
                    </div>
                  </td>

                  <!-- Aksi -->
                  <td class="px-4 py-2 border">
                    <inertia-link :href="route('testimonis.edit', testimoni.id)" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</inertia-link>
                    <inertia-link :href="route('testimonis.show', testimoni.id)" class="bg-green-500 text-white px-4 py-2 rounded">Show</inertia-link>
                    <button @click="deleteTestimoni(testimoni.id)" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
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
    testimonis: Array, // Menerima data testimoni dari Inertia
  },
  methods: {
    // Fungsi untuk menghapus testimoni
    deleteTestimoni(testimoniId) {
      if (confirm('Apakah Anda yakin ingin menghapus testimoni ini?')) {
        Inertia.delete(window.route('testimonis.destroy', testimoniId));
      }
    },

    // Fungsi untuk memotong review menjadi 50 karakter dan menambahkan titik-titik
    truncateReview(review) {
      if (review) {
        if (review.length > 50) {
          return review.slice(0, 50) + '...';  // Gabungkan 50 karakter pertama dan tambahkan titik-titik
        }
        return review;
      }
      return '';  // Jika tidak ada review
    }
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
