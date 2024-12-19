// Importing dependencies
import './bootstrap';  // Bootstrap JS (or other global JS)
import '../css/app.css'; // App styles

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { InertiaLink } from '@inertiajs/inertia-vue3'; // Import InertiaLink

// Define the app name from environment or default
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Register the InertiaLink component globally (if needed)
const app = createInertiaApp({
    title: (title) => `${title} - ${appName}`, // Set document title dynamically
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')), // Dynamically resolve pages
    setup({ el, App, props, plugin }) {
        // Create the app instance and mount it
        return createApp({ render: () => h(App, props) })
            .use(plugin) // Use Inertia.js plugin
            .use(ZiggyVue) // Use Ziggy for route helpers
            .component('inertia-link', InertiaLink) // Register InertiaLink globally
            .mount(el); // Mount the app
    },
    progress: {
        color: '#4B5563', // Set progress bar color
    },
});
