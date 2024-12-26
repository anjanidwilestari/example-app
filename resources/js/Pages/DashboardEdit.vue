<template>
  <Head title="Edit Tampilan Dashboard"></Head>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Tampilan</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
          <!-- Form untuk memilih setting -->
          <form @submit.prevent="saveSettings">
            <input type="hidden" name="_token" :value="csrfToken" />

            <!-- Pilih Buku -->
            <h3 class="text-2xl font-bold mb-4">Pilih Buku</h3>
            <select v-model="selectedBookId" id="book" class="form-select mt-1 block w-full">
              <option v-for="book in books" :key="book.id" :value="book.id">
                {{ book.title }}
              </option>
            </select>

            <!-- Pilih Testimoni -->
            <h3 class="text-2xl font-bold mb-4 mt-6">Pilih Testimoni</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              <div v-for="testimoni in testimonis" :key="testimoni.id" class="p-4 border rounded flex items-center">
                <input
                  type="checkbox"
                  :value="testimoni.id"
                  v-model="selectedTestimonisIds"
                  :id="'testimoni-' + testimoni.id"
                  class="mr-2"
                />
                <label :for="'testimoni-' + testimoni.id">
                  {{ testimoni.name_customer }}
                </label>
              </div>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
              Simpan Pengaturan
            </button>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Ambil data dari props yang dikirimkan oleh controller
const { books, currentBook, testimonis, selectedTestimonisIds: initialSelectedTestimonisIds, csrfToken } = usePage().props;

// Inisialisasi data
const selectedBookId = ref(currentBook?.id || null);
const selectedTestimonisIds = ref(Array.isArray(initialSelectedTestimonisIds) ? initialSelectedTestimonisIds : []);

// Fungsi untuk menyimpan pengaturan
const saveSettings = () => {
  // Validasi jika 1 buku dan 3 testimoni dipilih
  if (!selectedBookId.value) {
    alert('Pilih buku terlebih dahulu.');
    return;
  }

  if (selectedTestimonisIds.value.length !== 3) {
    alert('Pilih tepat 3 testimoni.');
    return;
  }

  // Kirim data ke backend menggunakan Inertia
  Inertia.post(route('saveSettings'), {
    book_id: selectedBookId.value,
    testimoni_ids: selectedTestimonisIds.value, // Kirim array ID testimoni yang dipilih
    _token: csrfToken, // Sertakan CSRF token jika diperlukan
  });
};
</script>
