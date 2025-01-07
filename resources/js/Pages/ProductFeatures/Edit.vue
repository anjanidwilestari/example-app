<script setup>
import { useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Props
const props = defineProps({
    feature: Object, // Receiving feature data from Inertia
});

// Form setup
const form = useForm({
    product_id: props.feature.product_id,
    feature: props.feature.feature,
    description: props.feature.description,
});

// Submit form
const submitForm = () => {
    form.put(route("product_features.update", props.feature.id), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Product Feature
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Edit the product feature details here.
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submitForm">
                        <!-- Product Select -->
                        <div>
                            <InputLabel for="product_id" value="Product" />
                            <TextInput
                                id="product_id"
                                v-model="form.product_id"
                                type="select"
                                :error="form.errors.product_id"
                                class="mt-1 block w-full"
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
                            <PrimaryButton :disabled="form.processing"
                                >Save Changes</PrimaryButton
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
