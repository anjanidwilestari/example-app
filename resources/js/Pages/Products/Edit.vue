<template>
    <section>
        <Head title="Edit Product" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Product
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Update the product details here.
                </p>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <form
                            @submit.prevent="submitForm"
                            class="mt-6 space-y-6"
                        >
                            <!-- Product Name -->
                            <div>
                                <InputLabel for="name" value="Product Name" />
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

                            <!-- Description -->
                            <div>
                                <InputLabel
                                    for="description"
                                    value="Description"
                                />
                                <TextInput
                                    id="description"
                                    v-model="form.description"
                                    class="form-input mt-1 block w-full"
                                />
                                <InputError
                                    :message="form.errors.description"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Price -->
                            <div>
                                <InputLabel for="price" value="Price" />
                                <TextInput
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    class="form-input mt-1 block w-full"
                                />
                                <InputError
                                    :message="form.errors.price"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Category -->
                            <div>
                                <InputLabel
                                    for="category_id"
                                    value="Category"
                                />
                                <select
                                    id="category_id"
                                    v-model="form.category_id"
                                    class="form-input mt-1 block w-full"
                                >
                                    <option value="" disabled>
                                        Select Category
                                    </option>
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                                <InputError
                                    :message="form.errors.category_id"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Subcategory -->
                            <div>
                                <InputLabel
                                    for="sub_category_id"
                                    value="Subcategory"
                                />
                                <select
                                    id="sub_category_id"
                                    v-model="form.sub_category_id"
                                    class="form-input mt-1 block w-full"
                                >
                                    <option value="" disabled>
                                        Select Subcategory
                                    </option>
                                    <option
                                        v-for="subCategory in subCategories"
                                        :key="subCategory.id"
                                        :value="subCategory.id"
                                    >
                                        {{ subCategory.name }}
                                    </option>
                                </select>
                                <InputError
                                    :message="form.errors.sub_category_id"
                                    class="mt-2"
                                />
                            </div>

                            <!-- Product Features Section -->
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold">
                                    Product Features
                                </h3>

                                <!-- List of existing features -->
                                <ul class="mt-4 space-y-2">
                                    <li
                                        v-for="feature in features"
                                        :key="feature.id"
                                        class="flex items-center gap-2"
                                    >
                                        <input
                                            v-model="feature.feature"
                                            type="text"
                                            class="form-input block w-full"
                                            @change="updateFeature(feature)"
                                        />
                                        <input
                                            v-model="feature.description"
                                            type="text"
                                            class="form-input block w-full"
                                            @change="updateFeature(feature)"
                                        />
                                        <button
                                            @click.prevent="
                                                deleteFeature(feature.id)
                                            "
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            Hapus
                                        </button>
                                    </li>
                                </ul>

                                <!-- Add new feature input -->
                                <div class="flex items-center gap-2 mt-4">
                                    <input
                                        v-model="newFeature.feature"
                                        type="text"
                                        placeholder="New feature"
                                        class="form-input block w-full"
                                    />
                                    <input
                                        v-model="newFeature.description"
                                        type="text"
                                        placeholder="New description"
                                        class="form-input block w-full"
                                    />
                                    <button
                                        @click.prevent="addFeature"
                                        class="text-green-600 hover:text-green-800"
                                    >
                                        Tambah
                                    </button>
                                </div>

                                <!-- Add new galleries product -->
                                <div class="mt-8">
                                    <h3 class="text-lg font-semibold">
                                        Product Galleries
                                    </h3>

                                    <!-- List of existing galleries -->
                                    <ul class="mt-4 space-y-2">
                                        <li
                                            v-for="gallery in galleries"
                                            :key="gallery.id"
                                            class="flex items-center gap-2"
                                        >
                                            <img
                                                :src="gallery.image_path"
                                                alt="Product Image"
                                                class="w-32 h-32 object-cover"
                                            />
                                            <button
                                                @click.prevent="
                                                    deleteGallery(gallery.id)
                                                "
                                                class="text-red-600 hover:text-red-800"
                                            >
                                                Hapus
                                            </button>
                                        </li>
                                    </ul>

                                    <!-- Add new gallery input -->
                                    <div class="flex items-center gap-2 mt-4">
                                        <input
                                            ref="imageInput"
                                            type="file"
                                            @change="handleFileUpload"
                                            class="form-input block w-full"
                                        />
                                        <button
                                            @click.prevent="addGallery"
                                            class="text-green-600 hover:text-green-800"
                                        >
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">
                                    Save
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    product: Object,
    categories: Array,
    subCategories: Array,
    features: Array, // Receiving features from the server
    galleries: { type: Array, default: () => [] }, // Ensure galleries is always an array
});

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    category_id: props.product.category_id,
    sub_category_id: props.product.sub_category_id,
});

const newFeature = ref({ feature: "", description: "" });
const features = ref([...props.features]); // Initialize features array

// Ensure galleries is always an array
const galleries = ref([...props.galleries]);

// Submit the form to update the product
const submitForm = () => {
    form.put(route("products.update", props.product.id), {
        onSuccess: () => form.reset(),
        onError: (errors) => console.error(errors),
    });
};

// Add new feature
const addFeature = () => {
    if (!newFeature.value.feature) return; // Avoid adding empty features

    // Send the data using Inertia
    Inertia.post(
        route("products.add-feature", props.product.id),
        newFeature.value,
        {
            onSuccess: (response) => {
                features.value.push(response.feature); // Add the new feature to the list
                newFeature.value.feature = ""; // Reset input field
                newFeature.value.description = "";
            },
        },
    );
};

// Update existing feature
const updateFeature = (feature) => {
    Inertia.patch(
        route("products.edit-feature", [props.product.id, feature.id]),
        feature,
        {
            onSuccess: (response) => {
                // The feature data will be updated automatically, no need for manual update
            },
        },
    );
};

// Delete feature
const deleteFeature = (featureId) => {
    Inertia.delete(
        route("products.delete-feature", [props.product.id, featureId]),
        {
            onSuccess: () => {
                features.value = features.value.filter(
                    (feature) => feature.id !== featureId,
                ); // Remove the feature from the list
            },
        },
    );
};

// New gallery data
const newGallery = ref({
    name: "",
    image: null, // For storing the uploaded image
});

// Handle file upload
const handleFileUpload = (event) => {
    newGallery.value.image = event.target.files[0]; // Store the uploaded image
};
const addGallery = () => {
    if (!newGallery.value.image) return; // Ensure image is selected

    const formData = new FormData();
    formData.append("image", newGallery.value.image); // Add the image to the FormData

    Inertia.post(route("products.add-gallery", props.product.id), formData, {
        onSuccess: (response) => {
            galleries.value.push(response.gallery); // Add the new gallery to the list
            newGallery.value.image = null; // Reset the file input
            if (this.$refs.imageInput) {
                this.$refs.imageInput.value = ""; // Reset file input display
            }
        },
    });
};
const updateGallery = (gallery) => {
    const formData = new FormData();
    if (gallery.newImage) {
        formData.append("image", gallery.newImage); // Append the new image if selected
    }

    Inertia.patch(
        route("products.edit-gallery", [props.product.id, gallery.id]),
        formData,
        {
            onSuccess: (response) => {
                const updatedGallery = galleries.value.find(
                    (g) => g.id === gallery.id,
                );
                updatedGallery.image_path = response.gallery.image_path; // Update image URL
                updatedGallery.newImage = null; // Reset the new image field
            },
        },
    );
};

// Delete gallery
const deleteGallery = (galleryId) => {
    Inertia.delete(
        route("products.delete-gallery", [props.product.id, galleryId]),
        {
            onSuccess: () => {
                galleries.value = galleries.value.filter(
                    (g) => g.id !== galleryId,
                ); // Remove the gallery from the list
            },
        },
    );
};
</script>
