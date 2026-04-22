<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';
import MainLayout from '@/layouts/avid/MainLayout.vue';

defineProps<{
    latestUsers: Array<{
        id: number;
        name: string;
        email: string;
        created_at: string;
    }>;
    latestProjects: Array<{
        id: number;
        name: string;
        description: string | null;
        created_at: string;
    }>;
}>();

let intervalId: number | undefined;

onMounted(() => {
    intervalId = window.setInterval(() => {
        router.reload({
            only: ['latestUsers', 'latestProjects'],
        });
    }, 10000);
});

onUnmounted(() => {
    if (intervalId) {
        clearInterval(intervalId);
    }
});
</script>

<template>
    <MainLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <h2 class="mb-4 text-lg font-semibold">Ultimi utenti aggiunti</h2>

                    <div v-if="latestUsers.length" class="space-y-3">
                        <div
                            v-for="user in latestUsers"
                            :key="user.id"
                            class="rounded-lg border p-3"
                        >
                            <div class="font-medium">{{ user.name }}</div>
                            <div class="text-sm text-gray-500">{{ user.email }}</div>
                            <div class="text-xs text-gray-400">
                                Creato il:
                                {{ new Date(user.created_at).toLocaleString('it-IT') }}
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">
                        Nessun utente presente.
                    </p>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <h2 class="mb-4 text-lg font-semibold">Ultimi progetti aggiunti</h2>

                    <div v-if="latestProjects.length" class="space-y-3">
                        <div
                            v-for="project in latestProjects"
                            :key="project.id"
                            class="rounded-lg border p-3"
                        >
                            <div class="font-medium">{{ project.name }}</div>
                            <div class="text-sm text-gray-500">
                                {{ project.description || 'Nessuna descrizione' }}
                            </div>
                            <div class="text-xs text-gray-400">
                                Creato il:
                                {{ new Date(project.created_at).toLocaleString('it-IT') }}
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">
                        Nessun progetto presente.
                    </p>
                </div>
            </div>
        </div>
    </MainLayout>
</template>