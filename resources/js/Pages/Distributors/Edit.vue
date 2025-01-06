<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { province } from "@/data/province.js"; // Ensure path is correct

// Props for receiving distributor data
const props = defineProps({
    distributor: Object,
});

// Initialize form using distributor data
const form = useForm({
    name: props.distributor.name,
    province: props.distributor.province,
    island: props.distributor.island,
    color: props.distributor.color,
});

// Data for provinces
const provinces = ref(
    province.objects.states_provinces.geometries.map((item) => ({
        name: item.properties.name,
        color: item.properties.color,
    })),
);

// Update color based on selected province
watch(
    () => form.province,
    (newProvince) => {
        const selectedProvince = provinces.value.find(
            (p) => p.name === newProvince,
        );
        form.color = selectedProvince ? selectedProvince.color : "#CCC"; // Default color if not found
    },
);

// Disable color input
const isColorDisabled = ref(true); // Using ref instead of data()

// Submit form function
const submitForm = () => {
    form.put(route("distributors.update", props.distributor.id), {
        onSuccess: () => {
            form.reset(); // Reset the form after successful submission
        },
        onError: (errors) => {
            console.error(errors); // Handle errors if any
        },
    });
};
</script>

<template>
    <section>
        <Head title="Edit Distributor" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Distributor
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Update the distributor details here.
                </p>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <form
                            @submit.prevent="submitForm"
                            class="mt-6 space-y-6"
                        >
                            <!-- Input Name -->
                            <div>
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError
                                    :message="form.errors.name"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Input Province -->
                            <div>
                                <InputLabel for="province" value="Province" />
                                <select
                                    id="province"
                                    v-model="form.province"
                                    class="form-input mt-1 block w-full"
                                >
                                    <option value="" disabled>
                                        Pilih Provinsi
                                    </option>
                                    <option
                                        v-for="province in provinces"
                                        :key="province.name"
                                        :value="province.name"
                                    >
                                        {{ province.name }}
                                    </option>
                                </select>
                                <InputError
                                    :message="form.errors.province"
                                    class="mt-2"
                                />
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
                                <InputError
                                    :message="form.errors.island"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Input Color -->
                            <div>
                                <InputLabel for="color" value="Color" />
                                <input
                                    id="color"
                                    v-model="form.color"
                                    type="color"
                                    class="mt-1 block w-full border-gray-300 rounded-md"
                                    :disabled="isColorDisabled"
                                />
                                <InputError
                                    :message="form.errors.color"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing"
                                    >Save</PrimaryButton
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
