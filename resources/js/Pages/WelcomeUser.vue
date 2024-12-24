<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

// Mendefinisikan props yang diterima, di sini kita menerima `firstBook` dari controller
const { currentBook } = usePage().props; // Mendapatkan data buku yang sedang ditampilkan

// Mendapatkan data testimoni dari props yang dikirim dari controller
const { testimonis } = usePage().props;
</script>

<template>
    <Head title="Welcome"></Head>

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <svg
                    viewBox="0 0 62 65"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-16 w-auto bg-gray-100 dark:bg-gray-900"
                >
                    <!-- Your SVG path here -->
                </svg>
            </div>

            <!-- Ensure this div is closed properly -->
            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6 lg:gap-8">
                    <div
                        href="https://ebooks.gramedia.com/id/buku/filosofi-kopi-sebuah-kolaborasi"
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                    >
                        <div class="py-12">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="container mx-auto mt-20 lg:mt-40 px-4 lg:px-20">
                                        <div class="flex flex-col md:grid md:grid-cols-3 gap-4">
                                            <div class="md:col-span-1 order-2 md:order-1">
                                                <h1 class="text-5xl md:text-6xl font-bold">{{ currentBook.title }}</h1>
                                                <h4 class="text-2xl font-semibold mt-16">{{ currentBook.author }}</h4>
                                                <p class="text-lg mt-4">{{ currentBook.description }}</p>
                                                <button
                                                    type="button"
                                                    class="text-white bg-gradient-to-b from-pink-100 via-pink-400 to-pink-500 hover:bg-gradient-to-r focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 shadow-lg shadow-pink-500/50 dark:shadow-lg dark:shadow-pink-800/80 font-medium rounded-lg text-sm px-6 py-3.5 text-center me-2 mb-2 mt-12"
                                                >
                                                    Lets dive in!
                                                </button>
                                            </div>

                                            <div class="order-1 md:order-2 md:col-span-2 flex justify-center items-center">
                                                <div class="imagecontainer md:relative md:w-full lg:xl:w-1/2">
                                                    <div class="background-rectangle absolute top-0 left-0 w-full h-full"></div>
                                                    <img
                                                        alt="Baby Scale"
                                                        loading="lazy"
                                                        width="1000"
                                                        height="1000"
                                                        decoding="async"
                                                        class="foreground-image relative z-10"
                                                        style="color: transparent"
                                                        :src="`/storage/${currentBook.image_path}`"  
                                                        sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
  data() {
    return {
      
    };
  },
};
</script>

<style scoped>
.container {
  max-width: 1024px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 5rem;
  padding-right: 5rem;
}

.foreground-image {
  width: 100%;
  height: auto;
}

.background-rectangle {
  background-color: rgba(214, 219, 220, 0.5);
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
}

.imagecontainer {
  position: relative;
  width: 100%;
}

h1 {
  font-size: 4rem;
  font-weight: bold;
}

h4 {
  font-size: 2rem;
  font-weight: 600;
  margin-top: 4rem;
}

p {
  font-size: 1rem;
  margin-top: 1rem;
}

button {
  background: linear-gradient(to bottom, #fbcfe8, #ec4899);
  color: white;
  padding: 1rem 2rem;
  margin-top: 2rem;
  border-radius: 0.375rem;
  font-size: 1rem;
  font-weight: 500;
}
</style>


<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
