<script setup>
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

// Props
const props = defineProps({
    galleries: Array,
    productId: {
        type: [String, Number], // Allow both String and Number types
        required: true,
        default: 0,
    },
});

// Ensure productId is a number (in case it's passed as a string)
const productId = Number(props.productId);

// Methods for deleting a gallery image
const deleteGallery = (galleryId) => {
    if (confirm("Are you sure you want to delete this gallery image?")) {
        Inertia.delete(route("product_galleries.destroy", galleryId));
    }
};
</script>

<template>
    <section>
        <Head title="Product Galleries" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Product Gallery Images
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div class="mb-4">
                                <inertia-link
                                    :href="
                                        route('product_galleries.create', {
                                            productId: productId,
                                        })
                                    "
                                    class="bg-blue-500 text-white px-4 py-2 rounded"
                                >
                                    Upload New Image
                                </inertia-link>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div
                                    v-for="gallery in galleries"
                                    :key="gallery.id"
                                    class="border p-4"
                                >
                                    <img
                                        :src="gallery.image_url"
                                        alt="Gallery Image"
                                        class="w-32 h-32 object-cover mb-4"
                                    />

                                    <div class="flex gap-4">
                                        <inertia-link
                                            :href="
                                                route(
                                                    'product_galleries.edit',
                                                    gallery.id,
                                                )
                                            "
                                            class="bg-yellow-500 text-white px-4 py-2 rounded"
                                        >
                                            Edit
                                        </inertia-link>
                                        <button
                                            @click="deleteGallery(gallery.id)"
                                            class="bg-red-500 text-white px-4 py-2 rounded"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
