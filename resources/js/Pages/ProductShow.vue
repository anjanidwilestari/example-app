<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    product: Object,
    relatedProducts: Array,
});
</script>

<template>
    <Head title="Product Details" />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <!-- Breadcrumb -->
            <nav class="text-gray-600 dark:text-gray-400 text-sm mb-6">
                <a href="/" class="hover:text-gray-900 dark:hover:text-white"
                    >Home</a
                >
                &gt;
                <a
                    href="/products"
                    class="hover:text-gray-900 dark:hover:text-white"
                    >Products</a
                >
                &gt; <span class="font-semibold">{{ product.name }}</span>
            </nav>

            <!-- Product Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div>
                    <div class="mb-4">
                        <!-- Set a fixed width and height for the main image -->
                        <img
                            :src="product.galleries[0]?.image_url"
                            alt="Main Image"
                            class="rounded-lg shadow-lg w-full max-w-md mx-auto object-cover h-80"
                        />
                    </div>
                    <div class="flex space-x-4 overflow-x-auto">
                        <img
                            v-for="gallery in product.galleries"
                            :key="gallery.id"
                            :src="gallery.image_url"
                            alt="Gallery Image"
                            class="w-20 h-20 object-cover rounded-lg shadow-md cursor-pointer"
                        />
                    </div>
                </div>

                <!-- Product Details -->
                <div class="space-y-6">
                    <h1
                        class="text-3xl font-semibold text-gray-900 dark:text-white"
                    >
                        {{ product.name }}
                    </h1>
                    <h2 class="text-xl text-gray-600 dark:text-gray-300">
                        {{ product.category.name }}
                    </h2>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        Rp {{ product.price.toLocaleString() }}
                    </p>

                    <!-- Actions -->
                    <div class="flex space-x-4 mt-4">
                        <button class="btn-primary px-6 py-2">Buy Now</button>
                        <button class="btn-secondary px-6 py-2">
                            Compare Product
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="mt-12">
                <h3
                    class="text-2xl font-semibold text-gray-900 dark:text-white"
                >
                    Deskripsi Produk
                </h3>
                <p class="mt-2 text-gray-700 dark:text-gray-300">
                    {{ product.description }}
                </p>
            </div>

            <!-- Features and Specifications -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4
                        class="text-xl font-semibold text-gray-900 dark:text-white"
                    >
                        Fitur
                    </h4>
                    <ul class="mt-4 space-y-2 text-gray-700 dark:text-gray-300">
                        <li
                            v-for="feature in product.features"
                            :key="feature.id"
                        >
                            <span class="font-semibold"
                                >{{ feature.feature }}:</span
                            >
                            {{ feature.description }}
                        </li>
                    </ul>
                </div>
                <div>
                    <h4
                        class="text-xl font-semibold text-gray-900 dark:text-white"
                    >
                        Spesifikasi
                    </h4>
                    <ul class="mt-4 space-y-2 text-gray-700 dark:text-gray-300">
                        <li
                            v-for="specification in product.specifications"
                            :key="specification.id"
                        >
                            <span class="font-semibold"
                                >{{ specification.specification }}:</span
                            >
                            {{ specification.description }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Related Products -->
            <div class="mt-12">
                <h3
                    class="text-2xl font-semibold text-gray-900 dark:text-white"
                >
                    Produk Terkait
                </h3>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-6"
                >
                    <div
                        v-for="relatedProduct in relatedProducts"
                        :key="relatedProduct.id"
                        class="border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden shadow-lg"
                    >
                        <img
                            :src="relatedProduct.image"
                            alt="Product Image"
                            class="w-full h-48 object-cover"
                        />
                        <div class="p-4 space-y-2">
                            <h4
                                class="text-lg font-semibold text-gray-900 dark:text-white"
                            >
                                {{ relatedProduct.name }}
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ relatedProduct.sub_category.name }}
                            </p>
                            <p
                                class="text-xl font-semibold text-gray-900 dark:text-white"
                            >
                                Rp {{ relatedProduct.price.toLocaleString() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Global button styles */
.btn-primary {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    text-align: center;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    text-align: center;
    cursor: pointer;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

/* Image Styles */
.product-images img {
    max-width: 100%;
    height: auto;
}

@media (max-width: 640px) {
    .product-images img {
        max-width: 100%;
    }
}
</style>
