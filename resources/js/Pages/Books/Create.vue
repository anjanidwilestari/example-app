<template>
  <div>
    <h1 class="text-xl font-semibold mb-4">Tambah Buku</h1>
    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label for="title" class="block">Judul</label>
        <input type="text" v-model="form.title" id="title" class="form-input mt-1 block w-full" />
      </div>
      <div class="mb-4">
        <label for="author" class="block">Penulis</label>
        <input type="text" v-model="form.author" id="author" class="form-input mt-1 block w-full" />
      </div>
      <div class="mb-4">
        <label for="author" class="block">Deskripsi</label>
        <input type="text" v-model="form.description" id="description" class="form-input mt-1 block w-full" />
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const form = ref({
  title: '',
  author: '',
  description: '', // Pastikan menambahkan description jika diperlukan
});

const submitForm = async () => {
  try {
    // Kirim data form ke server menggunakan axios
    await axios.post('/books', form.value);

    // Jika berhasil, redirect atau lakukan tindakan lain
    alert('Buku berhasil disimpan!');
    form.value = { title: '', author: '', description: '' }; // Reset form setelah submit
  } catch (error) {
    console.error('Gagal menyimpan buku:', error);
    alert('Terjadi kesalahan, silakan coba lagi.');
  }
};
</script>

