<script setup>
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { select, geoPath, geoMercator, easeLinear, selectAll } from "d3";
import * as topojson from "topojson-client";
import { province } from "@/data/province.js";

// Mendapatkan data dari props yang dikirim oleh fungsi welcome() di backend
const {
    currentBook,
    currentTestimonis,
    currentReasons,
    footers,
    distributors,
} = usePage().props;

// Reactive references untuk peta dan distributor
const mapRef = ref(null);
const groupedTravel = ref([]);

// Fungsi untuk mengelompokkan data distributor
const groupTravelData = (distributors) => {
    const grouped = distributors.reduce((acc, curr) => {
        // Cari apakah pulau sudah ada
        let islandGroup = acc.find((item) => item.island === curr.island);
        if (!islandGroup) {
            // Jika belum ada, tambahkan grup baru untuk pulau
            islandGroup = { island: curr.island, provinces: [] };
            acc.push(islandGroup);
        }

        // Cari apakah provinsi sudah ada di dalam pulau tersebut
        let provinceGroup = islandGroup.provinces.find(
            (item) => item.name === curr.province,
        );
        if (!provinceGroup) {
            // Jika belum ada, tambahkan grup baru untuk provinsi
            provinceGroup = { name: curr.province, distributors: [] };
            islandGroup.provinces.push(provinceGroup);
        }

        // Tambahkan distributor ke dalam grup provinsi
        provinceGroup.distributors.push({
            name: curr.name,
            color: curr.color,
        });

        return acc;
    }, []);

    return grouped;
};

// Mengelompokkan travel data pada saat komponen dimount
onMounted(() => {
    groupedTravel.value = groupTravelData(distributors); // Pastikan data distributor dikelompokkan
    console.log("Grouped Travel Data:", groupedTravel.value); // Debug hasil pengelompokan
    let width = window.innerWidth;
    let height = window.innerHeight;

    const svg = select(mapRef.value)
        .attr("width", width)
        .attr("height", height * 0.8)
        .attr("class", "map");

    const projection = geoMercator()
        .center([118.25, -5]) // Posisi untuk Indonesia
        .scale(width * 1.2)
        .translate([width / 2, height / 2]);

    const path = geoPath().projection(projection);

    function ready(data) {
        const g = svg.append("g");
        const features = topojson.feature(
            data,
            data.objects.states_provinces,
        ).features;

        g.selectAll("path")
            .data(features)
            .enter()
            .append("path")
            .attr("d", path)
            .attr("stroke", "black")
            .attr("strokeWidth", "0.2")
            .attr("fill", "white")
            .transition()
            .duration(2000)
            .delay((d, i) => i * 5)
            .ease(easeLinear)
            .attr("fill", (d) => {
                const provinceData = d.properties;

                // Cari provinsi langsung berdasarkan nama
                const matchingProvince = groupedTravel.value
                    .flatMap((group) => group.provinces)
                    .find((province) => province.name === provinceData.name);

                // Validasi data sebelum mengakses distributor pertama
                if (
                    matchingProvince &&
                    matchingProvince.distributors.length > 0
                ) {
                    return matchingProvince.distributors[0].color; // Warna distributor pertama
                }

                return "lightgray"; // Warna default jika tidak ditemukan
            });

        // Menambahkan title untuk hover
        g.selectAll("path")
            .append("title")
            .text((d) => {
                const provinceData = d.properties;
                const matchingProvince = groupedTravel.value
                    .flatMap((group) => group.provinces)
                    .find((province) => province.name === provinceData.name);

                if (
                    matchingProvince &&
                    matchingProvince.distributors.length > 0
                ) {
                    // Menggabungkan nama distributor menjadi satu string
                    const distributorNames = matchingProvince.distributors
                        .map((distributor) => distributor.name)
                        .join("\n");
                    return distributorNames; // Menampilkan daftar distributor
                }

                return "Tidak ada distributor"; // Pesan default jika tidak ada distributor
            });

        addLegend();
    }

    function addLegend() {
        const legend = svg.append("g").attr("class", "legend");
        const legendItemHeight = 20;
        const legendSpacing = 5;

        groupedTravel.value.forEach((item, index) => {
            const legendItem = legend
                .append("g")
                .attr(
                    "transform",
                    `translate(0, ${height * 0.8 + index * (legendItemHeight + legendSpacing) + legendSpacing})`,
                );

            legendItem
                .append("rect")
                .attr("x", 0)
                .attr("y", 0)
                .attr("width", legendItemHeight)
                .attr("height", legendItemHeight)
                .style("fill", item.distributors[0].color);

            legendItem
                .append("text")
                .attr("x", legendItemHeight + legendSpacing)
                .attr("y", legendItemHeight - legendSpacing)
                .text(item.island);
        });
    }

    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;

        projection.scale(width * 1.2).translate([width / 2, height / 2]);

        select("svg")
            .attr("width", width)
            .attr("height", height * 0.8);

        selectAll("path").attr("d", path);
    }

    ready(province);
    window.addEventListener("resize", resize);
});
</script>

<template>
    <Head title="Highlight"></Head>

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6 lg:gap-8">
                    <!-- Section Buku Terpilih -->
                    <div
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                    >
                        <div class="py-12">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div
                                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                                >
                                    <div
                                        class="container mx-auto mt-20 lg:mt-5 px-4 lg:px-20"
                                    >
                                        <div
                                            class="flex flex-col md:grid md:grid-cols-3 gap-4"
                                        >
                                            <div
                                                class="md:col-span-1 order-2 md:order-1"
                                            >
                                                <h1
                                                    class="text-5xl md:text-6xl font-bold"
                                                >
                                                    {{
                                                        currentBook.title ||
                                                        "Tidak Ada Buku Terpilih"
                                                    }}
                                                </h1>
                                                <h4
                                                    class="text-2xl font-semibold mt-16"
                                                >
                                                    {{
                                                        currentBook.author ||
                                                        "Penulis Tidak Diketahui"
                                                    }}
                                                </h4>
                                                <p class="text-lg mt-4">
                                                    {{
                                                        currentBook.description ||
                                                        "Deskripsi tidak tersedia."
                                                    }}
                                                </p>
                                                <button
                                                    type="button"
                                                    class="text-white bg-gradient-to-b from-pink-100 via-pink-400 to-pink-500 hover:bg-gradient-to-r focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 shadow-lg shadow-pink-500/50 dark:shadow-lg dark:shadow-pink-800/80 font-medium rounded-lg text-sm px-6 py-3.5 text-center me-2 mb-2 mt-12"
                                                >
                                                    Lets dive in!
                                                </button>
                                            </div>

                                            <div
                                                class="order-1 md:order-2 md:col-span-2 flex justify-center items-center"
                                            >
                                                <div
                                                    class="imagecontainer md:relative md:w-full lg:xl:w-1/2"
                                                >
                                                    <div
                                                        class="background-rectangle absolute top-0 left-0 w-full h-full"
                                                    ></div>
                                                    <img
                                                        alt="Gambar Buku"
                                                        loading="lazy"
                                                        width="1000"
                                                        height="1000"
                                                        decoding="async"
                                                        class="foreground-image relative z-10"
                                                        style="
                                                            color: transparent;
                                                        "
                                                        :src="
                                                            currentBook.image_path
                                                                ? `/storage/${currentBook.image_path}`
                                                                : '/images/placeholder-book.png'
                                                        "
                                                        sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Testimoni -->
                    <div
                        v-if="
                            Array.isArray(currentTestimonis) &&
                            currentTestimonis.length > 0
                        "
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 lg:gap-8"
                    >
                        <div
                            v-for="testimoni in currentTestimonis"
                            :key="testimoni.id"
                            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                        >
                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center"
                            >
                                <img
                                    v-if="testimoni.photo"
                                    :src="`/storage/photos/${testimoni.photo}`"
                                    alt="Foto Profile"
                                    class="w-20 h-20 rounded-full object-cover mb-4"
                                />
                                <p
                                    v-else
                                    class="w-20 h-20 rounded-full bg-gray-300 mb-4"
                                ></p>
                                <h3 class="text-xl font-semibold">
                                    {{ testimoni.name_customer }}
                                </h3>
                                <p class="text-gray-500 mb-4">
                                    {{ testimoni.workplace }}
                                </p>
                                <p
                                    class="text-gray-700 dark:text-gray-300 text-sm"
                                >
                                    {{ testimoni.review }}
                                </p>
                                <div
                                    v-if="testimoni.status"
                                    class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md text-xs"
                                >
                                    <span>Aktif</span>
                                </div>
                                <div
                                    v-else
                                    class="mt-4 px-4 py-2 bg-gray-400 text-white rounded-md text-xs"
                                >
                                    <span>Non-Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-center mt-6">
                        <p class="text-gray-500">
                            Belum ada testimoni untuk ditampilkan.
                        </p>
                    </div>

                    <!-- Section Kenapa Memilih Kami -->
                    <div
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                    >
                        <div class="py-12">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div
                                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                                >
                                    <div
                                        class="container mx-auto mt-10 lg:mt-5 px-4 lg:px-20"
                                    >
                                        <!-- Grid Layout: Kanan & Kiri -->
                                        <div
                                            class="grid grid-cols-1 md:grid-cols-3 gap-4"
                                        >
                                            <!-- Kolom Kiri -->
                                            <div class="md:col-span-2">
                                                <!-- Baris 1 dengan 2 kolom -->
                                                <div
                                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                                                >
                                                    <!-- Loop through selectedReasons to display dynamic content -->
                                                    <div
                                                        v-for="(
                                                            reason, index
                                                        ) in currentReasons"
                                                        :key="reason.id"
                                                        class="p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                                                    >
                                                        <div
                                                            class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center"
                                                        >
                                                            <img
                                                                v-if="
                                                                    reason.icon
                                                                "
                                                                :src="`/storage/icons/${reason.icon}`"
                                                                alt="Icon"
                                                                class="w-20 h-20 rounded-full object-cover mb-4"
                                                            />
                                                            <h3
                                                                class="text-xl font-semibold"
                                                            >
                                                                {{
                                                                    reason.title
                                                                }}
                                                            </h3>
                                                            <p
                                                                class="text-gray-700 dark:text-gray-300 text-sm"
                                                            >
                                                                {{
                                                                    reason.description
                                                                }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Kolom Kanan -->
                                            <div
                                                class="md:col-span-1 text-center mt-6 md:mt-0"
                                            >
                                                <h1
                                                    class="text-4xl md:text-5xl font-bold mb-4"
                                                >
                                                    Kenapa Memilih Kami?
                                                </h1>
                                                <h4
                                                    class="text-xl md:text-2xl font-semibold mb-6"
                                                >
                                                    Kami adalah pilihan terbaik
                                                    untuk kebutuhan Anda.
                                                </h4>
                                                <p class="text-lg mb-6">
                                                    Kami menawarkan layanan
                                                    terbaik dengan kualitas yang
                                                    sudah terjamin. Percayakan
                                                    kebutuhan Anda kepada kami
                                                    untuk hasil yang memuaskan.
                                                </p>
                                                <button
                                                    type="button"
                                                    class="text-white bg-gradient-to-b from-pink-100 via-pink-400 to-pink-500 hover:bg-gradient-to-r focus:ring-4 focus:outline-none focus:ring-pink-300 dark:focus:ring-pink-800 shadow-lg shadow-pink-500/50 dark:shadow-lg dark:shadow-pink-800/80 font-medium rounded-lg text-sm px-6 py-3.5 text-center me-2 mb-2"
                                                >
                                                    Let's dive in!
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Maps -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center"
                    >
                        <!-- Title and Learn more link -->
                        <div class="flex items-center justify-center">
                            <h1
                                class="text-2xl lg:text-5xl font-bold text-blue-800 dark:text-white"
                            >
                                Map Our Distributor
                            </h1>
                        </div>

                        <!-- SVG Map -->
                        <svg
                            ref="mapRef"
                            width="50%"
                            height="300px"
                            class="md:-pt-15"
                        ></svg>

                        <!-- Distributor Information -->
                        <div class="flex flex-row flex-wrap justify-center">
                            <div
                                v-for="(island, index) in groupedTravel"
                                :key="index"
                                class="flex flex-col items-center m-4 p-4"
                            >
                                <h1
                                    class="text-2xl lg:text-2xl font-bold text-blue-800 dark:text-white mb-4"
                                >
                                    {{ island.island }}
                                </h1>

                                <div
                                    class="flex flex-col items-center space-y-4"
                                >
                                    <div
                                        v-for="(
                                            province, pIndex
                                        ) in island.provinces"
                                        :key="pIndex"
                                        class="w-full"
                                    >
                                        <h2
                                            class="text-xl font-semibold text-gray-700 dark:text-gray-300"
                                        >
                                            {{ province.name }}
                                        </h2>

                                        <div
                                            class="flex flex-col items-start space-y-2"
                                        >
                                            <div
                                                v-for="(
                                                    distributor, dIndex
                                                ) in province.distributors"
                                                :key="dIndex"
                                                class="flex items-center space-x-2 p-2"
                                            >
                                                <div
                                                    class="w-5 h-5"
                                                    :style="{
                                                        backgroundColor:
                                                            distributor.color,
                                                    }"
                                                ></div>
                                                <p>{{ distributor.name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Distributor Information -->
                    </div>
                    <!-- End Maps -->
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Looping Footer Sections -->
                <div v-for="footer in footers" :key="footer.id">
                    <h4 class="text-xl font-semibold mb-4">
                        {{ footer.name }}
                    </h4>
                    <ul>
                        <li
                            v-for="subFooter in footer.sub_footers"
                            :key="subFooter.id"
                        >
                            <a
                                :href="
                                    subFooter.link.startsWith('http')
                                        ? subFooter.link
                                        : 'http://' + subFooter.link
                                "
                                target="_blank"
                                class="text-gray-400 hover:text-white"
                            >
                                {{ subFooter.name }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</template>
