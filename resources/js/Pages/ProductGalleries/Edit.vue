<script setup>
import { useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Props
const props = defineProps({
    gallery: Object, // Receiving gallery data from Inertia
});

// Form setup
const form = useForm({
    image_path: null, // Will store the new file, if selected
    current_image: props.gallery.image_path, // Store the current image path
});

// Handle file input change
const handleFileChange = (event) => {
    const file = event.target.files[0]; // Get the first selected file
    if (file) {
        form.image_path = file; // Set the file to the form data
    }
};

// Submit form
const submitForm = () => {
    const formData = new FormData();
    if (form.image_path) {
        formData.append("image_path", form.image_path);
    }
    formData.append("_method", "PUT"); // To update the gallery image

    form.put(route("product_galleries.update", props.gallery.id), {
        data: formData,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Product Gallery Image
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Edit the product gallery image here.
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submitForm">
                        <!-- Current Image Display -->
                        <div class="mb-4">
                            <strong>Current Image:</strong>
                            <img
                                :src="props.gallery.image_url"
                                alt="Product Gallery Image"
                                class="max-w-xs mt-2"
                            />
                        </div>

                        <!-- New Image Upload -->
                        <div>
                            <InputLabel
                                for="image_path"
                                value="New Image (optional)"
                            />
                            <input
                                type="file"
                                id="image_path"
                                @change="handleFileChange"
                                class="mt-1 block w-full"
                                :error="form.errors.image_path"
                            />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-4 mt-6">
                            <PrimaryButton :disabled="form.processing">
                                Save Changes
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
