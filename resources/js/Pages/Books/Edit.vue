<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  book: Object, // Buku yang akan diedit
});

const form = useForm({
  title: props.book.title,
  author: props.book.author,
  description: props.book.description,
  image_path: props.book.image_path,
});

const titleInput = ref(null);
const authorInput = ref(null);
const descriptionInput = ref(null);
const imageInput = ref(null);

const submitForm = () => {
  form.put(route('books.update', props.book.id), {
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
            <form @submit.prevent="submitForm" class="mt-6 space-y-6">
              <!-- Title Input -->
              <div>
                <InputLabel for="title" value="Book Title" />

                <TextInput
                  id="title"
                  ref="titleInput"
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
                  ref="authorInput"
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
                  ref="descriptionInput"
                  v-model="form.description"
                  class="border border-gray-300 rounded px-4 py-2 w-full"
                ></textarea>

                <InputError :message="form.errors.description" class="mt-2" />
              </div>

              <!-- Image Path Input -->
              <div>
                <InputLabel for="image_path" value="Image Path (Optional)" />

                <textarea
                  id="image_path"
                  ref="imageInput"
                  v-model="form.image_path"
                  class="border border-gray-300 rounded px-4 py-2 w-full"
                ></textarea>

                <InputError :message="form.errors.image_path" class="mt-2" />
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
