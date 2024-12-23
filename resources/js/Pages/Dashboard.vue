<template>
  <Head title="Dashboard"></Head>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">Buku yang Ditampilkan</div>
          
          <!-- Menampilkan data buku yang dipilih -->
          <h1 class="text-5xl md:text-6xl font-bold mt-8">{{ currentBook.title }}</h1>
          <h4 class="text-2xl font-semibold mt-16">{{ currentBook.author }}</h4>
          <p class="text-lg mt-4">{{ currentBook.description }}</p>

          <!-- Gambar Buku -->
          <div class="imagecontainer md:relative md:w-full lg:xl:w-1/2">
            <div class="background-rectangle absolute top-0 left-0 w-full h-full"></div>
            <img
              alt="Image Buku"
              loading="lazy"
              width="1000"
              height="1000"
              decoding="async"
              class="foreground-image relative z-10"
              :src="`/storage/${currentBook.image_path}`"
              sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
            />
          </div>
          
          <!-- Tombol Edit Tampilan -->
          <inertia-link
            :href="route('dashboard.edit')"
            class="text-white bg-gradient-to-b from-pink-100 via-pink-400 to-pink-500 hover:bg-gradient-to-r focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 shadow-lg shadow-pink-500/50 dark:shadow-lg dark:shadow-pink-800/80 font-medium rounded-lg text-sm px-6 py-3.5 text-center me-2 mb-2 mt-12"
          >
            Edit Tampilan
          </inertia-link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useRoute } from 'vue-router';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { currentBook } = usePage().props; // Mendapatkan data buku yang sedang ditampilkan

</script>
