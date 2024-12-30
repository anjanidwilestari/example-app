<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Inisialisasi form
const form = ref({
  name: '',
  province: '',
  island: '',
  color: '#ccc', // Default color
  errors: {},
  processing: false,
  recentlySuccessful: false,
});

// Submit form
const submitForm = async () => {
  form.value.processing = true;
  try {
    await axios.post('/distributors', form.value);  // Adjust the route as necessary
    alert('Distributor berhasil disimpan!');
    form.value = { name: '', province: '', island: '', color: '#ccc', errors: {}, processing: false, recentlySuccessful: true };
  } catch (error) {
    console.error('Gagal menyimpan distributor:', error);
    alert('Terjadi kesalahan, silakan coba lagi.');
    form.value.processing = false;
  }
};
</script>

<template>
  <section>
    <Head title="Tambah Distributor" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Distributor</h2>
        <p class="mt-1 text-sm text-gray-600">Add a new distributor with the details below.</p>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submitForm" class="space-y-6">
              <!-- Name -->
              <div>
                <InputLabel for="name" value="Name" />
                <TextInput
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.name" class="mt-2" />
              </div>

              <!-- Province -->
              <div>
                <InputLabel for="province" value="Province" />
                <TextInput
                  id="province"
                  v-model="form.province"
                  type="text"
                  class="form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.province" class="mt-2" />
              </div>

              <!-- Island -->
              <div>
                <InputLabel for="island" value="Island" />
                <TextInput
                  id="island"
                  v-model="form.island"
                  type="text"
                  class="form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.island" class="mt-2" />
              </div>

              <!-- Color -->
              <div>
                <InputLabel for="color" value="Color" />
                <input
                  id="color"
                  v-model="form.color"
                  type="color"
                  class="mt-1 block w-full border-gray-300 rounded-md"
                />
                <InputError :message="form.errors.color" class="mt-2" />
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
