<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import MainLayout from '@/layouts/avid/MainLayout.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('users.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <MainLayout>
        <Head title="Nuovo utente" />

        <div class="mx-auto max-w-2xl p-6">
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h1 class="text-xl font-semibold">Nuovo utente</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Inserisci i dati del nuovo utente.
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
                            autocomplete="name"
                        />
                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium">
                            Email
                        </label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="w-full rounded-lg border px-3 py-2"
                            autocomplete="email"
                        />
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-medium">
                            Password
                        </label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="w-full rounded-lg border px-3 py-2"
                            autocomplete="new-password"
                        />
                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div>
                        <label
                            for="password_confirmation"
                            class="mb-1 block text-sm font-medium"
                        >
                            Conferma password
                        </label>
                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="w-full rounded-lg border px-3 py-2"
                            autocomplete="new-password"
                        />
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
                            :href="route('users.index')"
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