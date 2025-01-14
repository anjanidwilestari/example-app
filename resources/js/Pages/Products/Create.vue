<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head } from "@inertiajs/vue3";

// Inisialisasi form
const form = useForm({
    name: "",
    description: "",
    price: "",
    category_id: "",
    sub_category_id: "",
});

// Properti yang diterima dari parent
defineProps({
    categories: Array,
    subCategories: Array,
});

// Define the event emitter
const emit = defineEmits(["close"]);

// Emit close event to parent
const closeModal = () => {
    emit("close");
};
</script>

<template>
    <div>
        <Head title="Tambah Produk" />
        <div
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
        >
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-xl font-semibold mb-4">Tambah Produk</h2>
                <form
                    @submit.prevent="form.post(route('products.store'))"
                    class="space-y-6"
                >
                    <!-- Name -->
                    <div>
                        <InputLabel for="name" value="Product Name" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="form-input mt-1 block w-full"
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <InputLabel for="description" value="Deskripsi" />
                        <textarea
                            id="description"
                            v-model="form.description"
                            class="form-input border border-gray-300 rounded px-4 py-2 w-full"
                        ></textarea>
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
                            :modelValue="form.price.toString()"
                            @update:modelValue="
                                (value) => (form.price = Number(value))
                            "
                            type="text"
                            class="form-input mt-1 block w-full"
                        />
                        <InputError :message="form.errors.price" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div>
                        <InputLabel for="category_id" value="Category" />
                        <select
                            id="category_id"
                            v-model="form.category_id"
                            class="form-input mt-1 block w-full"
                        >
                            <option value="" disabled>Pilih Kategori</option>
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
                        <InputLabel for="sub_category_id" value="Subcategory" />
                        <select
                            id="sub_category_id"
                            v-model="form.sub_category_id"
                            class="form-input mt-1 block w-full"
                        >
                            <option value="" disabled>Pilih Subkategori</option>
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

                    <!-- Submit Button -->
                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing"
                            >Save</PrimaryButton
                        >
                        <button
                            @click="closeModal"
                            type="button"
                            class="ml-2 text-gray-500"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
