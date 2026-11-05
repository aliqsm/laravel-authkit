import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [

                // --------------------------------------
                // CSS
                // --------------------------------------
                'resources/css/app.css',
                'resources/css/custom-class/fs.css',
                'resources/css/custom-class/margin.css',
                'resources/css/custom-class/padding.css',
                'resources/css/layout.css',

                // --------------------------------------
                // JS
                // --------------------------------------
                'resources/js/app.js',
                'resources/js/auth/login.js',
                'resources/js/auth/logout.js',
                'resources/js/auth/forgot-password.js',
                'resources/js/auth/register.js',
                'resources/js/auth/auth-form.js',
                'resources/js/auth/confirm-password.js',
                'resources/js/auth/reset-password.js',
                'resources/js/auth/verification-email.js',
                'resources/js/auth/two-factor-challenge.js',
                'resources/js/auth/two-factor-setup.js',
                'resources/js/dashboard/change-password.js',
                'resources/js/dashboard/update-profile.js',
                'resources/js/dashboard/terminate-other-sessions.js',
            ],
            buildDirectory: 'build',
        }),
    ],

    build: {
        manifest: 'manifest.json',
        emptyOutDir: true,
    },
});