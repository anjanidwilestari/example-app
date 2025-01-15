<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import SidebarLink from "@/Components/SidebarLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md">
            <div class="px-4 py-6">
                <Link :href="route('dashboard')">
                    <ApplicationLogo
                        class="block h-9 w-auto fill-current text-gray-800"
                    />
                </Link>
            </div>

            <!-- Sidebar Links -->
            <div class="space-y-4 px-4">
                <SidebarLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                >
                    Dashboard
                </SidebarLink>
                <SidebarLink
                    :href="route('books.index')"
                    :active="route().current('books.index')"
                >
                    Buku
                </SidebarLink>
                <SidebarLink
                    :href="route('testimonis.index')"
                    :active="route().current('testimonis.index')"
                >
                    Testimoni
                </SidebarLink>
                <SidebarLink
                    :href="route('footers.index')"
                    :active="route().current('footers.index')"
                >
                    Footer
                </SidebarLink>
                <SidebarLink
                    :href="route('distributors.index')"
                    :active="route().current('distributors.index')"
                >
                    Distributors
                </SidebarLink>
                <SidebarLink
                    :href="route('reasons.index')"
                    :active="route().current('reasons.index')"
                >
                    Reasons
                </SidebarLink>
                <!-- Add a Dropdown for Products -->
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                            >
                                Produk
                                <svg
                                    class="ml-2 -mr-0.5 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('products.index')"
                            >Products</DropdownLink
                        >
                        <DropdownLink :href="route('product_categories.index')"
                            >Categories</DropdownLink
                        >
                        <DropdownLink
                            :href="route('product_sub_categories.index')"
                            >Sub Categories</DropdownLink
                        >
                        <DropdownLink :href="route('product_features.index')"
                            >Features</DropdownLink
                        >
                        <DropdownLink
                            :href="route('product_specifications.index')"
                            >Specifications</DropdownLink
                        >
                    </template>
                </Dropdown>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1">
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo and Navigation Links -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                    >Dashboard</NavLink
                                >
                                <NavLink
                                    :href="route('books.index')"
                                    :active="route().current('books.index')"
                                    >Buku</NavLink
                                >
                                <NavLink
                                    :href="route('testimonis.index')"
                                    :active="
                                        route().current('testimonis.index')
                                    "
                                    >Testimoni</NavLink
                                >
                                <NavLink
                                    :href="route('footers.index')"
                                    :active="route().current('footers.index')"
                                    >Footer</NavLink
                                >
                                <NavLink
                                    :href="route('distributors.index')"
                                    :active="
                                        route().current('distributors.index')
                                    "
                                    >Distributors</NavLink
                                >
                                <NavLink
                                    :href="route('reasons.index')"
                                    :active="route().current('reasons.index')"
                                    >Reasons</NavLink
                                >
                            </div>
                        </div>

                        <!-- Settings Dropdown and Hamburger for Mobile -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        >
                                            {{ $page.props.auth.user.name }}
                                            <svg
                                                class="ms-2 -me-0.5 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')"
                                        >Profile</DropdownLink
                                    >
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        >Log Out</DropdownLink
                                    >
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
