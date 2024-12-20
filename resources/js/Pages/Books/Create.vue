<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
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

<template>
  <section> 
    <Head title="Edit Books"></Head>
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Buku</h2>
        <p class="mt-1 text-sm text-gray-600">
          Add the new details of the book here.
        </p>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
              <!-- Input Judul -->
              <div>
                <InputLabel for="title" value="Book Title"/>
                <TextInput
                  id="title"
                  v-model="form.title"
                  type="text"
                  class="form-input mt-1 block w-full"
                />
              </div>

              <!-- Input Penulis -->
              <div>
                <InputLabel for="author" value="Author"/>
                <TextInput
                  id="author"
                  v-model="form.author"
                  type="text"
                  class="form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.author" class="mt-2" />
              </div>

              <!-- Input Deskripsi -->
              <div>
                <InputLabel for="description" value="Description" />
                <textarea
                  id="description"
                  v-model="form.description"
                  class=" form-input border border-gray-300 rounded px-4 py-2 w-full"
                ></textarea>
                <InputError :message="form.errors.description" class="mt-2" />
              </div>

              <!-- Input Gambar -->
              <div>
                <InputLabel for="image" value="Image (Optional)" />
                <input
                  type="file"
                  id="image"
                  ref="imageInput"
                  @change="form.image = $event.target.files[0]"
                  class=" form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.image" class="mt-2" />
              </div>


              <!-- Input Video -->
              <div>
                <InputLabel for="video" value="Video (Optional)" />
                <input
                  type="file"
                  id="video"
                  ref="videoInput"
                  @change="form.video = $event.target.files[0]"
                  class=" form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.video" class="mt-2" />
              </div>

              <!-- Input Audio -->
              <div>
                <InputLabel for="audio" value="Audio (Optional)" />
                <input
                  type="file"
                  id="audio"
                  ref="audioInput"
                  @change="form.audio = $event.target.files[0]"
                  class=" form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.audio" class="mt-2" />
              </div>

              <!-- Submit Button -->
              <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                  enter-active-class="transition ease-in-out"
                  enter-from-class="opacity-0"
                  leave-active-class="transition ease-in-out"
                  leave-to-class="opacity-0"
                >
                  <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </section>
</template>
