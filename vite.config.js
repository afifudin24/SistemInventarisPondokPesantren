import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/dashboard.css",
                "resources/vendors/mdi/css/materialdesignicons.min.css",
                "resources/vendors/ti-icons/css/themify-icons.css",
                "resources/vendors/css/vendor.bundle.base.css",
                "resources/vendors/font-awesome/css/font-awesome.min.css",
                "resources/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css",
                "resources/js/app.js",
                "resources/vendors/js/vendor.bundle.base.js",
                "resources/js/bootstrap.js",
                "resources/js/dashboard.js",
                "resources/js/dashboard-dark.js",
                "resources/js/jquery.cookie.js",
                "resources/js/jquery-file-upload.js",
                "resources/js/settings.js",
                "resources/js/chart.js",
            ],
            refresh: true,
        }),
    ],
});
