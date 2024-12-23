<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { defineProps } from 'vue';

// Mendefinisikan props yang diterima, di sini kita menerima `firstBook` dari controller
const props = defineProps({
  firstBook: Object,  // Buku pertama yang diterima dari controller
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="container mx-auto mt-20 lg:mt-40 px-4 lg:px-20">
                        <div class="flex flex-col md:grid md:grid-cols-3 gap-4">
                        <!-- Left Column -->
                        <div class="md:col-span-1 order-2 md:order-1">
                            <h1 class="text-5xl md:text-6xl font-bold">{{ props.firstBook.title }}</h1>
                            <h4 class="text-2xl font-semibold mt-16">{{ props.firstBook.author }}</h4>
                            <p class="text-lg mt-4">{{ props.firstBook.description }}</p>
                            
                            
                            <button
                            type="button"
                            class="text-white bg-gradient-to-b from-pink-100 via-pink-400 to-pink-500 hover:bg-gradient-to-r focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 shadow-lg shadow-pink-500/50 dark:shadow-lg dark:shadow-pink-800/80 font-medium rounded-lg text-sm px-6 py-3.5 text-center me-2 mb-2 mt-12"
                            >
                            <inertia-link
                                :href="route('dashboard.edit')"
                            >Edit Tampilan</inertia-link>
                            </button>
                        </div>

                        <!-- Right Column (Image) -->
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
                                :src="`/storage/${props.firstBook.image_path}`"  
                                sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
                            />
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </AuthenticatedLayout>
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
