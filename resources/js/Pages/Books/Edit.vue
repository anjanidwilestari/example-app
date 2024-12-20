<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// Prop Book yang diterima dari controller
const props = defineProps({
  book: Object,
});

// Inisialisasi form dengan data buku
const form = useForm({
  title: props.book.title,
  author: props.book.author,
  description: props.book.description,
  image: null,
  video: null,
  audio: null,
});

// Fungsi untuk menangani perubahan file
const handleFileChange = (type, event) => {
  form[type] = event.target.files[0]; // Store the selected file to the corresponding type
};

// Fungsi untuk submit form
const submitForm = () => {
  const data = new FormData(); // Membuat objek FormData untuk mengirim file dan data lainnya
  data.append('title', form.title);
  data.append('author', form.author);
  data.append('description', form.description);
  
  // Menambahkan file hanya jika ada file yang dipilih
  if (form.image) data.append('image', form.image);
  if (form.video) data.append('video', form.video);
  if (form.audio) data.append('audio', form.audio);
  
  // Mengirim data menggunakan inertia.js
  form.post(route('books.update', props.book.id), {
    data,
    onSuccess: () => {
      form.reset(); // Reset form setelah submit sukses
    },
    onError: (errors) => {
      // Handling form validation errors
      console.error(errors);
    },
  });
};
</script>

<template>
  <section>
    <Head title="Edit Books"></Head>
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Buku</h2>
        <p class="mt-1 text-sm text-gray-600">Update the details of the book here.</p>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submitForm" class="mt-6 space-y-6" enctype="multipart/form-data">
              <!-- Input Judul -->
              <div>
                <InputLabel for="title" value="Book Title" />
                <TextInput
                  id="title"
                  v-model="form.title"
                  type="text"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.title" class="mt-2" />
              </div>

              <!-- Input Penulis -->
              <div>
                <InputLabel for="author" value="Author" />
                <TextInput
                  id="author"
                  v-model="form.author"
                  type="text"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.author" class="mt-2" />
              </div>

              <!-- Input Deskripsi -->
              <div>
                <InputLabel for="description" value="Description" />
                <textarea
                  id="description"
                  v-model="form.description"
                  class="border border-gray-300 rounded px-4 py-2 w-full"
                ></textarea>
                <InputError :message="form.errors.description" class="mt-2" />
              </div>

              <!-- Input Gambar -->
              <div>
                <InputLabel for="image" value="Image (Optional)" />
                <input
                  type="file"
                  id="image"
                  @change="handleFileChange('image', $event)"
                  class="mt-1 block w-full"
                />
                <!-- Display current file name if available -->
                <span v-if="form.image">
                  {{ form.image.name }}
                </span>
                <span v-if="!form.image && props.book.image_path">
                  Current file: {{ props.book.image_path }}
                </span>
                <InputError :message="form.errors.image" class="mt-2" />
              </div>

              <!-- Input Video -->
              <div>
                <InputLabel for="video" value="Video (Optional)" />
                <input
                  type="file"
                  id="video"
                  @change="handleFileChange('video', $event)"
                  class="mt-1 block w-full"
                />
                <!-- Display current file name if available -->
                <span v-if="form.video">
                  {{ form.video.name }}
                </span>
                <span v-if="!form.video && props.book.video_path">
                  Current file: {{ props.book.video_path }}
                </span>
                <InputError :message="form.errors.video" class="mt-2" />
              </div>

              <!-- Input Audio -->
              <div>
                <InputLabel for="audio" value="Audio (Optional)" />
                <input
                  type="file"
                  id="audio"
                  @change="handleFileChange('audio', $event)"
                  class="mt-1 block w-full"
                />
                <!-- Display current file name if available -->
                <span v-if="form.audio">
                  {{ form.audio.name }}
                </span>
                <span v-if="!form.audio && props.book.audio_path">
                  Current file: {{ props.book.audio_path }}
                </span>
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
