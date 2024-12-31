<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { province } from '@/data/province.js'; // Pastikan path sesuai

// Inisialisasi form
const form = useForm({
  name: '',
  province: '',
  island: '',
  color: '', // Warna akan diatur otomatis
});

// Proses data provinsi dari `province.js`
const provinces = ref(
  province.objects.states_provinces.geometries.map((item) => ({
    name: item.properties.name,
    color: item.properties.color,
  }))
);

// Perbarui warna berdasarkan provinsi
watch(
  () => form.province,
  (newProvince) => {
    const selectedProvince = provinces.value.find((p) => p.name === newProvince);
    form.color = selectedProvince ? selectedProvince.color : '#CCC'; // Default jika tidak ada
  }
);
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
            <form @submit.prevent="form.post(route('distributors.store'))" class="space-y-6">
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
                <select
                  id="province"
                  v-model="form.province"
                  class="form-input mt-1 block w-full"
                >
                  <option value="" disabled>Pilih Provinsi</option>
                  <option v-for="province in provinces" :key="province.name" :value="province.name">
                    {{ province.name }}
                  </option>
                </select>
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
                  readonly
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


