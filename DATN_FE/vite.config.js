import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],
    // server: {
    //     host: "0.0.0.0", // Cho phép truy cập từ bên ngoài
    //     port: 5173, // Hoặc cổng bạn muốn
    // },
});
