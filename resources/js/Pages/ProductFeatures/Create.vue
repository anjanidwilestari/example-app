<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Props to get the list of products
const props = defineProps({
    products: Array, // Pass the list of products from the controller
});

// Form setup
const form = useForm({
    product_id: "",
    feature: "",
    description: "",
});

// Submit form
const submitForm = () => {
    form.post(route("product_features.store"), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Product Feature
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Create a new product feature here.
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submitForm">
                        <!-- Product Select -->
                        <div>
                            <InputLabel for="product_id" value="Product" />
                            <select
                                id="product_id"
                                v-model="form.product_id"
                                :error="form.errors.product_id"
                                class="form-input mt-1 block w-full"
                            >
                                <option value="" disabled>
                                    Select Product
                                </option>
                                <!-- Loop through products and create options -->
                                <option
                                    v-for="product in props.products"
                                    :key="product.id"
                                    :value="product.id"
                                >
                                    {{ product.name }}
                                </option>
                            </select>
                            <!-- Display validation error -->
                            <InputError
                                :message="form.errors.product_id"
                                class="mt-2"
                            />
                        </div>

                        <!-- Feature Input -->
                        <div>
                            <InputLabel for="feature" value="Feature" />
                            <TextInput
                                id="feature"
                                v-model="form.feature"
                                type="text"
                                class="mt-1 block w-full"
                                :error="form.errors.feature"
                            />
                        </div>

                        <!-- Description Input -->
                        <div>
                            <InputLabel for="description" value="Description" />
                            <TextInput
                                id="description"
                                v-model="form.description"
                                type="text"
                                class="mt-1 block w-full"
                                :error="form.errors.description"
                            />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-4 mt-6">
                            <PrimaryButton :disabled="form.processing">
                                Create Feature
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
