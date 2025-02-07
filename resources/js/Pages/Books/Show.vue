<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import AuditList from "./AuditList.vue";

// Prop Book yang diterima dari controller
const props = defineProps({
    book: Object,
});
</script>

<template>
    <section>
        <Head title="Book Details"></Head>
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Book Details
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    View the details of the book here.
                </p>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="space-y-6">
                            <!-- Judul Buku -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Book Title
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{ props.book.title }}
                                </p>
                            </div>

                            <!-- Penulis -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Author
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{ props.book.author }}
                                </p>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Description
                                </h3>
                                <p class="text-lg text-gray-600">
                                    {{ props.book.description }}
                                </p>
                            </div>

                            <!-- Gambar Buku -->
                            <div v-if="props.book.image_path">
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Image
                                </h3>
                                <img
                                    :src="`/storage/${props.book.image_path}`"
                                    alt="Book Image"
                                    class="mt-4 w-full max-w-md"
                                />
                            </div>

                            <!-- Video Buku -->
                            <div v-if="props.book.video_path">
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Video
                                </h3>
                                <video controls class="mt-4 w-full max-w-md">
                                    <source
                                        :src="`/storage/${props.book.video_path}`"
                                        type="video/mp4"
                                    />
                                    Your browser does not support the video tag.
                                </video>
                            </div>

                            <!-- Audio Buku -->
                            <div v-if="props.book.audio_path">
                                <h3
                                    class="text-2xl font-semibold text-gray-800"
                                >
                                    Audio
                                </h3>
                                <audio controls class="mt-4 w-full max-w-md">
                                    <source
                                        :src="`/storage/${props.book.audio_path}`"
                                        type="audio/mp3"
                                    />
                                    Your browser does not support the audio
                                    element.
                                </audio>
                            </div>
                            <AuditList :bookId="book.id" class="mt-6" />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </section>
</template>
