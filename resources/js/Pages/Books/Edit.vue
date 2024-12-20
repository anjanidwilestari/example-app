<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
</script>



<template>
  <Head title="Edit Books"> </Head>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Buku</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div >
              <InputLabel for="title" value="{{ book.title }}">
                <TextInput
                    id="title"
                   
                    v-model="form.title"
                    type="text"
                    class="mt-1 block w-full"
                  
                />
                <InputError :message="form.errors.tittle" class="mt-2" />
              </InputLabel>
              </div >
              
                
              <div class="mb-4">
                <label for="author" class="block">Penulis</label>
                <input v-model="form.author" type="text" id="author" class="border border-gray-300 rounded px-4 py-2 w-full" />
              </div>
              <div class="mb-4">
                <label for="description" class="block">Deskripsi</label>
                <textarea v-model="form.description" id="description" class="border border-gray-300 rounded px-4 py-2 w-full"></textarea>
              </div>
              <div class="mb-4">
                <label for="image" class="block">Gambar</label>
                <textarea v-model="form.image_path" id="image_path" class="border border-gray-300 rounded px-4 py-2 w-full"></textarea>
              </div>
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
