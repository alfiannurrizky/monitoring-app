import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import dotenv from "dotenv";

dotenv.config();

export default defineConfig({
    server: {
        host: "0.0.0.0",
        port: Number(process.env.VITE_PORT) || 5173,
        strictPort: true,
        cors: true,
        origin: process.env.APP_URL,
        hmr: {
            host: process.env.VITE_HOST || "localhost",
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
