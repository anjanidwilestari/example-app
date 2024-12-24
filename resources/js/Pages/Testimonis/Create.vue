<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
  name_customer: '',
  workplace: '',
  review: '',
  photo: null,
  status: false,  // default status
  errors: {}, 
  processing: false,
  recentlySuccessful: false,
});

const handleFileChange = (event) => {
  form.photo = event.target.files[0];  // Menyimpan file yang dipilih
};

const submitForm = async () => {
  form.processing = true;
  try {
    const formData = new FormData();
    formData.append('name_customer', form.name_customer);
    formData.append('workplace', form.workplace);
    formData.append('review', form.review);
    if (form.photo) formData.append('photo', form.photo);
    formData.append('status', form.status);

    // Kirim data ke server
    await form.post(route('testimonis.store'), {
      forceFormData: true,
      onFinish: () => form.processing = false
    });

    form.recentlySuccessful = true;
    form.reset();  // Reset form
  } catch (error) {
    console.error('Error submitting form:', error);
    form.processing = false;
  }
};
</script>

<template>
  <section>
    <Head title="Tambah Testimoni" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Testimoni</h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submitForm" class="mt-6 space-y-6" enctype="multipart/form-data">
              <!-- Input Nama Konsumen -->
              <div>
                <InputLabel for="name_customer" value="Nama Konsumen" />
                <TextInput
                  id="name_customer"
                  v-model="form.name_customer"
                  type="text"
                  class="form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.name_customer" class="mt-2" />
              </div>

              <!-- Input Tempat Kerja -->
              <div>
                <InputLabel for="workplace" value="Tempat Kerja" />
                <TextInput
                  id="workplace"
                  v-model="form.workplace"
                  type="text"
                  class="form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.workplace" class="mt-2" />
              </div>

              <!-- Input Review -->
              <div>
                <InputLabel for="review" value="Review" />
                <textarea
                  id="review"
                  v-model="form.review"
                  class="form-input border border-gray-300 rounded px-4 py-2 w-full"
                ></textarea>
                <InputError :message="form.errors.review" class="mt-2" />
              </div>

              <!-- Input Foto -->
              <div>
                <InputLabel for="photo" value="Foto (Optional)" />
                <input
                  type="file"
                  id="photo"
                  ref="photoInput"
                  @change="handleFileChange"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.photo" class="mt-2" />
              </div>

              <!-- Status -->
              <div>
                <InputLabel for="status" value="Aktif" />
                <input
                  type="checkbox"
                  id="status"
                  v-model="form.status"
                  class="mt-1"
                />
                <InputError :message="form.errors.status" class="mt-2" />
              </div>

              <!-- Submit Button -->
              <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Simpan</PrimaryButton>
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Testimoni berhasil disimpan!</p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </section>
</template>
