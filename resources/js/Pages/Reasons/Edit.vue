<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  reason: Object,
});

const form = useForm({
  title: props.reason.title,
  description: props.reason.description,
  icon: null,
  status: props.reason.status,
  errors: {},
  processing: false,
});

const handleFileChange = (event) => {
  form.icon = event.target.files[0];
};

const submitForm = async () => {
  form.processing = true;
  try {
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('description', form.description);
    if (form.icon) formData.append('icon', form.icon);
    formData.append('status', form.status);

    await form.post(route('reasons.update', props.reason.id), {
      forceFormData: true,
      data: formData,
      onFinish: () => form.processing = false,
    });

    form.recentlySuccessful = true;
  } catch (error) {
    console.error('Error updating reason:', error);
    form.processing = false;
  }
};
</script>

<template>
  <section>
    <Head title="Edit Reason" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Reason</h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submitForm" class="mt-6 space-y-6" enctype="multipart/form-data">
              <div>
                <InputLabel for="title" value="Judul" />
                <TextInput
                  id="title"
                  v-model="form.title"
                  type="text"
                  class="form-input mt-1 block w-full"
                />
                <InputError :message="form.errors.title" class="mt-2" />
              </div>

              <div>
                <InputLabel for="description" value="Deskripsi" />
                <textarea
                  id="description"
                  v-model="form.description"
                  class="form-input border border-gray-300 rounded px-4 py-2 w-full"
                ></textarea>
                <InputError :message="form.errors.description" class="mt-2" />
              </div>

              <div>
                <InputLabel for="icon" value="Icon (Optional)" />
                <input
                  type="file"
                  id="icon"
                  @change="handleFileChange"
                  class="mt-1 block w-full"
                />
                <InputError :message="form.errors.icon" class="mt-2" />
              </div>

              <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Reason berhasil diperbarui!</p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </section>
</template>
