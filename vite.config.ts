import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';
import Components from 'unplugin-vue-components/vite';
import { PrimeVueResolver } from '@primevue/auto-import-resolver';
import AutoImport from 'unplugin-auto-import/vite';
import i18n from 'laravel-vue-i18n/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        AutoImport({
            vueTemplate: true,
            dts: "resources/js/types/auto-imports.d.ts",
            dirs: ["resources/js/avid/lib"],
            imports: [
                "vue",
                {
                    "@inertiajs/vue3": ["router", "useForm", "usePage"],
                },
                {
                    "primevue/useconfirm": ["useConfirm"]
                },
                {
                    "notivue": [['push', 'notify']]
                },
                {
                    "laravel-vue-i18n": [['trans', 't']]
                },
            ],
        }),
        Components({
            dts: "resources/js/types/components.d.ts",
            dirs: [],
            resolvers: [
                (name: string) => {
                    const components = ["Link", "Head"]

                    if (components.includes(name)) {
                        return {
                            name: name,
                            from: "@inertiajs/vue3",
                        }
                    }
                },

                (name: string) => {
                    const components = ["Modal", "ModalLink"]

                    if (components.includes(name)) {
                        return {
                            name: name,
                            from: "@inertiaui/modal-vue",
                        }
                    }
                },

                PrimeVueResolver({
                    components: {
                        prefix: 'Prime',
                    },
                })
            ]
        }),
        i18n(),

    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
});
