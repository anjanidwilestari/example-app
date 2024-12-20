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
  image: props.book.image, // Untuk gambar
  video: props.book.video, // Untuk video
  audio: props.book.audio, // Untuk audio
});

// Referensi untuk file input
const imageInput = ref(null);
const videoInput = ref(null);
const audioInput = ref(null);

// Fungsi untuk submit form
const submitForm = () => {
  const formData = new FormData();

  // Menambahkan data form selain file
  formData.append('title', form.title);
  formData.append('author', form.author);
  formData.append('description', form.description);

  // Menambahkan file jika ada
  if (form.image) formData.append('image', form.image);
  if (form.video) formData.append('video', form.video);
  if (form.audio) formData.append('audio', form.audio);

  // Kirim data ke server
  form.put(route('books.update', props.book.id), {
    data: formData,
    onSuccess: () => {
      form.reset();
    },
    onError: (errors) => {
      form.errors = errors; // Menangani error validasi
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
        <p class="mt-1 text-sm text-gray-600">
          Update the details of the book here.
        </p>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submitForm" class="mt-6 space-y-6" enctype="multipart/form-data">
              <!-- Title Input -->
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

              <!-- Author Input -->
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

              <!-- Description Input -->
              <div>
                <InputLabel for="description" value="Description" />
                <textarea
                  id="description"
                  v-model="form.description"
                  class="border border-gray-300 rounded px-4 py-2 w-full"
                ></textarea>
                <InputError :message="form.errors.description" class="mt-2" />
              </div>

              <!-- Image Input -->
              <div>
                <InputLabel for="image" value="Image (Optional)" />
                <input
                  type="file"
                  id="image"
                  ref="imageInput"
                  @change="form.image = $event.target.files[0]"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.image" class="mt-2" />
              </div>

              <!-- Video Input -->
              <div>
                <InputLabel for="video" value="Video (Optional)" />
                <input
                  type="file"
                  id="video"
                  ref="videoInput"
                  @change="form.video = $event.target.files[0]"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.video" class="mt-2" />
              </div>

              <!-- Audio Input -->
              <div>
                <InputLabel for="audio" value="Audio (Optional)" />
                <input
                  type="file"
                  id="audio"
                  ref="audioInput"
                  @change="form.audio = $event.target.files[0]"
                  class="mt-1 block w-full"
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
