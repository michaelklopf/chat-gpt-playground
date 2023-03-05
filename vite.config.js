import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
const { resolve } = require("path");

export default ({ command }) => ({
    base: command === "serve" ? "" : "/dist/",
    publicDir: "fake_dir_so_nothing_gets_copied",
    build: {
        manifest: true,
        outDir: resolve(__dirname, "public/dist"),
        rollupOptions: {
            input: "resources/js/app.js",
        },
    },

    plugins: [vue()],

    resolve: {
        alias: {
            "@": resolve("./resources/js"),
        },
    },
});
