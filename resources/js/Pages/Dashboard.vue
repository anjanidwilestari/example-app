<template>
  <Head title="Dashboard"></Head>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <!-- Buku yang Dipilih -->
          <div class="mb-8">
            <h3 class="text-2xl font-bold mb-4">Buku yang Ditampilkan</h3>
            <div v-if="currentBook" class="card bg-gray-100 p-4 rounded-lg shadow-md">
              <div class="flex justify-center mb-4">
                <img
                  v-if="currentBook.image_path"
                  :src="`/storage/${currentBook.image_path}`"
                  alt="Gambar Buku"
                  class="rounded-lg w-full max-h-64 object-contain"
                />
              </div>
              <h4 class="text-xl font-semibold mb-2">{{ currentBook.title }}</h4>
              <p class="text-gray-700 mb-1"><strong>Penulis:</strong> {{ currentBook.author }}</p>
              <p class="text-gray-600">{{ currentBook.description }}</p>
            </div>
            <p v-else class="text-red-500">Belum ada buku yang dipilih.</p>
          </div>

          <!-- Testimoni yang Dipilih -->
          <div>
            <h3 class="text-2xl font-bold mb-4">Testimoni</h3>
            <div v-if="selectedTestimonis.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              <div
                v-for="testimoni in selectedTestimonis"
                :key="testimoni.id"
                class="card bg-gray-100 p-4 rounded-lg shadow-md"
              >
                <p class="text-gray-700"><strong>{{ testimoni.name_customer }}</strong></p>
                <p class="text-gray-600">{{ testimoni.review }}</p>
              </div>
            </div>
            <p v-else class="text-red-500">Belum ada testimoni yang dipilih.</p>
          </div>

          <!-- Footer Custom -->
          <div class="mt-8">
            <h3 class="text-2xl font-bold mb-4">Footer</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              <!-- Looping through footers -->
              <div v-for="footer in footers" :key="footer.id" class="col-span-1">
                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                  <h4 class="font-semibold">{{ footer.name }}</h4>
                  <!-- Looping through subFooters -->
                  <div v-for="subFooter in footer.sub_footers" :key="subFooter.id" class="mt-2">
                    <a :href="subFooter.link.startsWith('http') ? subFooter.link : 'http://' + subFooter.link" target="_blank" class="text-blue-500">
                      {{ subFooter.name }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tombol Edit -->
          <div class="mt-8 text-right">
            <a
              href="/dashboard-edit"
              class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
            >
              Edit Tampilan
            </a>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { currentBook, selectedTestimonis, footers } = usePage().props;
</script>
