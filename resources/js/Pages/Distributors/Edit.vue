<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Mendapatkan data distributor yang diterima dari controller
const props = defineProps({
  distributor: Object,
});

// Inisialisasi form menggunakan data distributor
const form = useForm({
  name: props.distributor.name,
  province: props.distributor.province,
  island: props.distributor.island,
  color: props.distributor.color,
});

// Fungsi untuk submit form
const submitForm = () => {
  form.put(route('distributors.update', props.distributor.id), {
    onSuccess: () => {
      form.reset(); // Reset form setelah submit berhasil
    },
    onError: (errors) => {
      console.error(errors); // Handling jika terjadi kesalahan
    },
  });
};
</script>

<template>
  <section>
    <Head title="Edit Distributor"></Head>
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Distributor</h2>
        <p class="mt-1 text-sm text-gray-600">Update the distributor details here.</p>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submitForm" class="mt-6 space-y-6">
              <!-- Input Name -->
              <div>
                <InputLabel for="name" value="Name" />
                <TextInput
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.name" class="mt-2" />
              </div>

              <!-- Input Province -->
              <div>
                <InputLabel for="province" value="Province" />
                <TextInput
                  id="province"
                  v-model="form.province"
                  type="text"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.province" class="mt-2" />
              </div>

              <!-- Input Island -->
              <div>
                <InputLabel for="island" value="Island" />
                <TextInput
                  id="island"
                  v-model="form.island"
                  type="text"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.island" class="mt-2" />
              </div>

              <!-- Input Color -->
              <div>
                <InputLabel for="color" value="Color" />
                <TextInput
                  id="color"
                  v-model="form.color"
                  type="text"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.color" class="mt-2" />
              </div>

              <!-- Submit Button -->
              <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </section>
</template>
