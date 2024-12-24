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
          <div v-if="currentBook">
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
          </div>
          
          <!-- Pesan jika tidak ada buku yang dipilih -->
          <div v-else>
            <p class="text-lg text-red-500 mt-8">Belum ada buku yang dipilih.</p>
          </div>

          <!-- Section with 3 Cards and Testimonis -->
          <div v-if="testimonis.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 lg:gap-8">
                        <div
                            v-for="(testimoni, index) in testimonis.slice(0, 3)"
                            :key="testimoni.id"
                            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                        >
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                                <img
                                    v-if="testimoni.photo"
                                    :src="`/storage/photos/${testimoni.photo}`"
                                    alt="Foto Profile"
                                    class="w-20 h-20 rounded-full object-cover mb-4"
                                />
                                <p v-else class="w-20 h-20 rounded-full bg-gray-300 mb-4"></p>
                                <h3 class="text-xl font-semibold">{{ testimoni.name_customer }}</h3>
                                <p class="text-gray-500 mb-4">{{ testimoni.workplace }}</p>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">{{ testimoni.review }}</p>
                                <div v-if="testimoni.status" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md text-xs">
                                    <span>Aktif</span>
                                </div>
                                <div v-else class="mt-4 px-4 py-2 bg-gray-400 text-white rounded-md text-xs">
                                    <span>Non-Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center mt-6">
                        <p class="text-gray-500">Belum ada testimoni untuk ditampilkan.</p>
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
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { currentBook, testimonis } = usePage().props; // Mendapatkan data buku yang sedang ditampilkan

</script>
