<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Props to get the product information
const props = defineProps({
    product: Object, // Receiving product data from Inertia
});

// Form setup
const form = useForm({
    product_id: props.product.id,
    image_path: null, // This will store the selected file
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
    formData.append("product_id", form.product_id);
    formData.append("image_path", form.image_path);

    form.post(route("product_galleries.store"), {
        data: formData,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Upload New Image to Product Gallery
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Upload a new image for the product gallery.
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submitForm">
                        <!-- Image Upload -->
                        <div>
                            <InputLabel for="image_path" value="Image" />
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
                                Upload Image
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
