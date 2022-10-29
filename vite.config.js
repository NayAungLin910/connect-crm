import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'public/css/custom-auth.css',
                'public/css/custom.css',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/showToast.js',
                'resources/js/viewOrg.jsx',
                'resources/js/viewContact.jsx',
                'resources/js/viewSource.jsx',
                'resources/js/viewProduct.jsx',
                'resources/js/viewBusiness.jsx',
                'resources/js/viewLead.jsx',
                'resources/js/viewActivity.jsx',
                'resources/js/mainViewActivity.jsx',
                'resources/js/viewAccount.jsx',
                'resources/js/home.jsx',
            ],
            refresh: true,
        }),
        react(),
    ],
});
