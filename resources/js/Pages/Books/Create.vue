<template>
  <div>
    <h1 class="text-xl font-semibold mb-4">Tambah Buku</h1>
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <!-- Input Judul -->
      <div class="mb-4">
        <label for="title" class="block">Judul</label>
        <input type="text" v-model="form.title" id="title" class="form-input mt-1 block w-full" />
      </div>

      <!-- Input Penulis -->
      <div class="mb-4">
        <label for="author" class="block">Penulis</label>
        <input type="text" v-model="form.author" id="author" class="form-input mt-1 block w-full" />
      </div>

      <!-- Input Deskripsi -->
      <div class="mb-4">
        <label for="description" class="block">Deskripsi</label>
        <input type="text" v-model="form.description" id="description" class="form-input mt-1 block w-full" />
      </div>

      <!-- Input Gambar -->
      <div class="mb-4">
        <label for="image" class="block">Gambar</label>
        <input type="file" id="image" @change="handleFileChange('image', $event)" class="form-input mt-1 block w-full" />
      </div>

      <!-- Input Video -->
      <div class="mb-4">
        <label for="video" class="block">Video</label>
        <input type="file" id="video" @change="handleFileChange('video', $event)" class="form-input mt-1 block w-full" />
      </div>

      <!-- Input Audio -->
      <div class="mb-4">
        <label for="audio" class="block">Audio</label>
        <input type="file" id="audio" @change="handleFileChange('audio', $event)" class="form-input mt-1 block w-full" />
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

// Inisialisasi form dengan data yang diperlukan
const form = ref({
  title: '',
  author: '',
  description: '',
  image: null,
  video: null,
  audio: null,
});

// Fungsi untuk menangani perubahan file
const handleFileChange = (type, event) => {
  form.value[type] = event.target.files[0]; // Menyimpan file yang dipilih
};

// Fungsi untuk mengirim form ke server
const submitForm = async () => {
  try {
    const formData = new FormData();
    formData.append('title', form.value.title);
    formData.append('author', form.value.author);
    formData.append('description', form.value.description);

    // Menambahkan file ke FormData
    if (form.value.image) formData.append('image', form.value.image);
    if (form.value.video) formData.append('video', form.value.video);
    if (form.value.audio) formData.append('audio', form.value.audio);

    // Mengirim data ke server menggunakan axios
    const response = await axios.post('/books', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    alert('Buku berhasil disimpan!');
    form.value = { title: '', author: '', description: '', image: null, video: null, audio: null }; // Reset form
  } catch (error) {
    console.error('Gagal menyimpan buku:', error);
    alert('Terjadi kesalahan, silakan coba lagi.');
  }
};
</script>
