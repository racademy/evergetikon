import { defineConfig } from 'vite';
import path from 'path';
import { globSync } from 'glob';

// Define the base path for assets
const basePath = path.resolve(__dirname, 'assets');

// Get all SCSS and JS files for template parts (flexible content blocks)
const templateScssFiles = globSync(path.join(basePath, 'scss/template-parts/**/*.scss'));
const templateJsFiles = globSync(path.join(basePath, 'js/template-parts/**/*.js'));

// Define entry points
const inputFiles = {
    'global': path.join(basePath, 'scss/global.scss'), // Global SCSS
    'global-js': path.join(basePath, 'js/global.js'),  // Global JS
};

// Add template part SCSS
templateScssFiles.forEach(file => {
    const name = path.relative(path.join(basePath, 'scss/template-parts'), file)
        .replace(/\.scss$/, ''); // Remove the .scss extension
    inputFiles[`template-parts/css/${name}`] = file; // Output to dist/template-parts/css
});

// Add template part JS
templateJsFiles.forEach(file => {
    const name = path.relative(path.join(basePath, 'js/template-parts'), file)
        .replace(/\.js$/, ''); // Remove the .js extension
    inputFiles[`template-parts/js/${name}`] = file; // Output to dist/template-parts/js
});

// Export Vite config
export default defineConfig({
    build: {
        rollupOptions: {
            input: inputFiles,
            output: {
                entryFileNames: '[name].js',
                assetFileNames: '[name].[ext]',
                chunkFileNames: 'chunks/[name]-[hash].js', // Handle chunked files in case of code splitting
            },
        },
        outDir: 'dist', // Output directory
        sourcemap: true,  // Enable sourcemaps for easier debugging
        minify: 'esbuild', // Use esbuild for faster builds (default in Vite)
    },
    server: {
        watch: {
            usePolling: true, // Useful in certain environments (e.g., Docker, WSL) to detect changes
        },
    },
});
