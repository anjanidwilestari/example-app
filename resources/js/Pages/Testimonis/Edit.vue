<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Prop Book yang diterima dari controller
const props = defineProps({
  testimoni: Object,
});

// Inisialisasi form dengan data yang ada
const form = useForm({
  name_customer: props.testimoni.name_customer,
  workplace: props.testimoni.workplace,
  review: props.testimoni.review,
  photo: null,
  status: props.testimoni.status,
  errors: {},
  processing: false,
});

const handleFileChange = (event) => {
  // Periksa apakah event benar-benar ada dan memiliki target.files
  if (event.target && event.target.files) {
    form.photo = event.target.files[0];  // Menyimpan file yang dipilih
  }
};


const submitForm = async () => {
  form.processing = true;
  try {
    const formData = new FormData();
    formData.append('name_customer', form.name_customer);
    formData.append('workplace', form.workplace);
    formData.append('review', form.review);
    if (form.photo) {
      formData.append('photo', form.photo);
    }
    formData.append('status', form.status);

    // Kirim data menggunakan PUT request
    await form.post(route('testimonis.update', props.testimoni.id), {
      forceFormData: true,
      data: formData,  // Pastikan FormData dikirim
      onFinish: () => form.processing = false,
    });

    form.recentlySuccessful = true;
  } catch (error) {
    console.error('Error updating testimonial:', error);
    form.processing = false;
  }
};

</script>

<template>
  <section>
    <Head title="Edit Testimoni" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Testimoni</h2>
        <p class="mt-1 text-sm text-gray-600">Update the details of the testimoni here.</p>
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
                <!-- Display current file name if available -->
                <span v-if="form.photo">
                  {{ form.photo.name }}
                </span>
                <span v-if="!form.photo && props.testimoni.photo">
                  Current file: {{ props.testimoni.photo }}
                </span>
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
                <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Testimoni berhasil diperbarui!</p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </section>
</template>
