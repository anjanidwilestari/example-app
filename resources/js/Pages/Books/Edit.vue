<template>
  <div>
    <h1 class="text-xl font-semibold mb-4">Edit Buku</h1>
    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label for="title" class="block">Judul</label>
        <input v-model="form.title" type="text" id="title" class="border border-gray-300 rounded px-4 py-2 w-full" />
      </div>
      <div class="mb-4">
        <label for="author" class="block">Penulis</label>
        <input v-model="form.author" type="text" id="author" class="border border-gray-300 rounded px-4 py-2 w-full" />
      </div>
      <div class="mb-4">
        <label for="description" class="block">Deskripsi</label>
        <textarea v-model="form.description" id="description" class="border border-gray-300 rounded px-4 py-2 w-full"></textarea>
      </div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
  </div>
</template>

<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    book: Object,
  },
  data() {
    return {
      form: { ...this.book },
    };
  },
  methods: {
    submitForm() {
      Inertia.put(route('books.update', this.book.id), this.form);
    },
  },
};
</script>
