<template>
  <div>
    <!-- Menampilkan Buku yang Dipilih -->
    <div v-if="currentBook">
      <h1 class="text-5xl">{{ currentBook.title }}</h1>
      <p class="text-lg">{{ currentBook.description }}</p>
    </div>

    <!-- Menampilkan Testimoni yang Dipilih -->
    <div v-if="selectedTestimonis.length > 0">
      <h2 class="text-2xl">Testimoni:</h2>
      <ul>
        <li v-for="testimoni in selectedTestimonis" :key="testimoni.id">
          <p>{{ testimoni.name_customer }}: {{ testimoni.review }}</p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const { currentBook, selectedTestimonis } = usePage().props;
</script>
