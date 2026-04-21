<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import MainLayout from '@/layouts/avid/MainLayout.vue';

const form = useForm({
    name: '',
    description: '',
});

const submit = () => {
    form.post(route('projects.store'));
};
</script>

<template>
    <MainLayout>
        <Head title="Nuovo progetto" />

        <div class="mx-auto max-w-2xl p-6">
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h1 class="text-xl font-semibold">Nuovo progetto</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Inserisci i dati del nuovo progetto.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium">
                            Nome
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="w-full rounded-lg border px-3 py-2"
                        />
                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label for="description" class="mb-1 block text-sm font-medium">
                            Descrizione
                        </label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            class="w-full rounded-lg border px-3 py-2"
                            rows="4"
                        />
                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button
                            type="submit"
                            class="rounded-lg bg-black px-4 py-2 text-white disabled:opacity-50"
                            :disabled="form.processing"
                        >
                            Salva
                        </button>

                        <Link
                            :href="route('projects.index')"
                            class="rounded-lg border px-4 py-2"
                        >
                            Annulla
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </MainLayout>
</template>