import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "public/js/**/*", "resources/js/app.js"],
      refresh: [
        ".env",
        "public/assets/**",
        "resources/**/*",
        "resources/routes/**",
        "resources/views/**",
        "routes/**",
        "app/**",
        "lang/**",
        "config/**",
      ],
    }),
  ],
});
//# sourceMappingURL=vite.config.min.js.map
