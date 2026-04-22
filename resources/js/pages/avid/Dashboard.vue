<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';
import MainLayout from '@/layouts/avid/MainLayout.vue';

const props = defineProps<{
    totalUsers: number;
    totalProjects: number;
    totalTasks: number;
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
    latestTasks: Array<{
        id: number;
        name: string;
        description: string | null;
        created_at: string;
    }>;
    upcomingTasks?: Array<{
        id: number;
        name: string;
        description: string | null;
        due_date: string | null;
        status: string;
        priority: string;
        project: {
            id: number;
            name: string;
        } | null;
    }>;
}>();

let intervalId: number | undefined;

onMounted(() => {
    intervalId = window.setInterval(() => {
        router.reload({
            only: [
                'totalUsers',
                'totalProjects',
                'totalTasks',
                'latestUsers',
                'latestProjects',
                'latestTasks',
                'upcomingTasks',
            ],
            preserveScroll: true,
            preserveState: true,
        });
    }, 10000);
});

onUnmounted(() => {
    if (intervalId) {
        clearInterval(intervalId);
    }
});

const getDueDateClass = (dueDate: string | null) => {
    if (!dueDate) {
        return 'text-gray-400';
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const due = new Date(dueDate);
    due.setHours(0, 0, 0, 0);

    const diffInMs = due.getTime() - today.getTime();
    const diffInDays = diffInMs / (1000 * 60 * 60 * 24);

    if (diffInDays <= 0) {
        return 'text-red-600 font-semibold';
    }

    if (diffInDays <= 3) {
        return 'text-yellow-600 font-semibold';
    }

    return 'text-gray-500';
};

const getTaskBorderClass = (dueDate: string | null) => {
    if (!dueDate) {
        return 'border';
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const due = new Date(dueDate);
    due.setHours(0, 0, 0, 0);

    const diffInMs = due.getTime() - today.getTime();
    const diffInDays = diffInMs / (1000 * 60 * 60 * 24);

    if (diffInDays <= 0) {
        return 'border border-red-300';
    }

    if (diffInDays <= 3) {
        return 'border border-yellow-300';
    }

    return 'border';
};

const formatDueDate = (dueDate: string | null) => {
    if (!dueDate) {
        return 'Nessuna data';
    }

    return new Date(dueDate).toLocaleDateString('it-IT');
};

const formatStatus = (status: string) => {
    switch (status) {
        case 'todo':
            return 'Da fare';
        case 'in_progress':
            return 'In corso';
        case 'done':
            return 'Completata';
        default:
            return status;
    }
};

const formatPriority = (priority: string) => {
    switch (priority) {
        case 'low':
            return 'Bassa';
        case 'medium':
            return 'Media';
        case 'high':
            return 'Alta';
        default:
            return priority;
    }
};
</script>

<template>
    <MainLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="space-y-4">
                    <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <h2 class="text-sm font-medium text-gray-500">Totale utenti</h2>
                        <p class="mt-2 text-3xl font-bold">{{ totalUsers }}</p>
                    </div>

                    <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <h2 class="text-sm font-medium text-gray-500">Ultimo utente aggiunto</h2>
                        <p class="mt-2 text-base font-semibold">
                            {{ latestUsers.length ? latestUsers[0].name : 'Nessun utente' }}
                        </p>
                        <p v-if="latestUsers.length" class="mt-1 text-sm text-gray-500">
                            {{ latestUsers[0].email }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <h2 class="text-sm font-medium text-gray-500">Totale progetti</h2>
                        <p class="mt-2 text-3xl font-bold">{{ totalProjects }}</p>
                    </div>

                    <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <h2 class="text-sm font-medium text-gray-500">Ultimo progetto aggiunto</h2>
                        <p class="mt-2 text-base font-semibold">
                            {{ latestProjects.length ? latestProjects[0].name : 'Nessun progetto' }}
                        </p>
                        <p v-if="latestProjects.length" class="mt-1 text-sm text-gray-500">
                            {{ latestProjects[0].description || 'Nessuna descrizione' }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <h2 class="text-sm font-medium text-gray-500">Totale task</h2>
                        <p class="mt-2 text-3xl font-bold">{{ totalTasks }}</p>
                    </div>

                    <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <h2 class="text-sm font-medium text-gray-500">Ultima task inserita</h2>
                        <p class="mt-2 text-base font-semibold">
                            {{ latestTasks.length ? latestTasks[0].name : 'Nessuna task' }}
                        </p>
                        <p v-if="latestTasks.length" class="mt-1 text-sm text-gray-500">
                            {{ latestTasks[0].description || 'Nessuna descrizione' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
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

                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <h2 class="mb-4 text-lg font-semibold">Ultime task inserite</h2>

                    <div v-if="latestTasks.length" class="space-y-3">
                        <div
                            v-for="task in latestTasks"
                            :key="task.id"
                            class="rounded-lg border p-3"
                        >
                            <div class="font-medium">{{ task.name }}</div>
                            <div class="text-sm text-gray-500">
                                {{ task.description || 'Nessuna descrizione' }}
                            </div>
                            <div class="text-xs text-gray-400">
                                Creata il:
                                {{ new Date(task.created_at).toLocaleString('it-IT') }}
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">
                        Nessuna task presente.
                    </p>
                </div>
            </div>

            <div class="grid gap-4">
                <div class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <h2 class="mb-4 text-lg font-semibold">Task in scadenza</h2>

                    <div v-if="props.upcomingTasks?.length" class="space-y-3">
                        <div
                            v-for="task in props.upcomingTasks"
                            :key="task.id"
                            class="rounded-lg p-3"
                            :class="getTaskBorderClass(task.due_date)"
                        >
                            <div class="font-medium">{{ task.name }}</div>

                            <div class="text-sm text-gray-500">
                                {{ task.description || 'Nessuna descrizione' }}
                            </div>

                            <div class="text-sm text-gray-500">
                                Progetto: {{ task.project?.name || 'Nessun progetto' }}
                            </div>

                            <div class="text-sm text-gray-500">
                                Stato: {{ formatStatus(task.status) }}
                            </div>

                            <div class="text-sm text-gray-500">
                                Priorità: {{ formatPriority(task.priority) }}
                            </div>

                            <div class="text-xs" :class="getDueDateClass(task.due_date)">
                                Scadenza: {{ formatDueDate(task.due_date) }}
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">
                        Nessuna task in scadenza.
                    </p>
                </div>
            </div>
        </div>
    </MainLayout>
</template>