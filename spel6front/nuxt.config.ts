import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  vite: { plugins: [tailwindcss()] },
  css: ["~/assets/css/main.css"],
  runtimeConfig: {
    public: {
      apiBaseUrl:
        process.env.NUXT_PUBLIC_API_BASE_URL ?? "http://localhost:8000/api",
      storageBaseUrl:
        process.env.NUXT_PUBLIC_STORAGE_BASE_URL ?? "http://localhost:8000",
    },
  },
});
