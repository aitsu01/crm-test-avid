<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';
import MainLayout from '@/layouts/avid/MainLayout.vue';

const props = defineProps<{
    isAdmin: boolean;
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
    overdueTasks?: Array<{
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
    completedTasks?: Array<{
        id: number;
        name: string;
        description: string | null;
        due_date: string | null;
        status: string;
        priority: string;
        created_at: string;
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
                'isAdmin',
                'totalUsers',
                'totalProjects',
                'totalTasks',
                'latestUsers',
                'latestProjects',
                'latestTasks',
                'upcomingTasks',
                'overdueTasks',
                'completedTasks',
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

    if (diffInDays < 0) {
        return 'text-red-700 font-semibold';
    }

    if (diffInDays === 0) {
        return 'text-red-600 font-semibold';
    }

    if (diffInDays <= 3) {
        return 'text-yellow-700 font-semibold';
    }

    return 'text-gray-500';
};

const getUpcomingCardClass = (dueDate: string | null) => {
    if (!dueDate) {
        return 'border border-gray-200';
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const due = new Date(dueDate);
    due.setHours(0, 0, 0, 0);

    const diffInMs = due.getTime() - today.getTime();
    const diffInDays = diffInMs / (1000 * 60 * 60 * 24);

    if (diffInDays === 0) {
        return 'border border-red-300 bg-red-50/60';
    }

    if (diffInDays <= 3) {
        return 'border border-yellow-300 bg-yellow-50/60';
    }

    return 'border border-gray-200';
};

const getOverdueCardClass = () => {
    return 'border border-red-300 bg-red-50/70';
};

const getCompletedCardClass = () => {
    return 'border border-emerald-300 bg-emerald-50/70';
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

const getPriorityBadgeClass = (priority: string) => {
    switch (priority) {
        case 'high':
            return 'bg-red-100 text-red-700 border border-red-200';
        case 'medium':
            return 'bg-yellow-100 text-yellow-700 border border-yellow-200';
        case 'low':
            return 'bg-green-100 text-green-700 border border-green-200';
        default:
            return 'bg-gray-100 text-gray-700 border border-gray-200';
    }
};

const getStatusBadgeClass = (status: string) => {
    switch (status) {
        case 'todo':
            return 'bg-slate-100 text-slate-700 border border-slate-200';
        case 'in_progress':
            return 'bg-blue-100 text-blue-700 border border-blue-200';
        case 'done':
            return 'bg-emerald-100 text-emerald-700 border border-emerald-200';
        default:
            return 'bg-gray-100 text-gray-700 border border-gray-200';
    }
};
</script>

<template>
    <MainLayout>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid gap-4" :class="props.isAdmin ? 'md:grid-cols-3' : 'md:grid-cols-2'">
                <div v-if="props.isAdmin" class="space-y-4">
                    <div class="rounded-xl border border-sidebar-border/70 p-4 shadow-sm dark:border-sidebar-border">
                        <h2 class="text-sm font-medium text-gray-500">Totale utenti</h2>
                        <p class="mt-2 text-3xl font-bold">{{ totalUsers }}</p>
                    </div>

                    <div class="rounded-xl border border-sidebar-border/70 p-4 shadow-sm dark:border-sidebar-border">
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
                    <div class="rounded-xl border border-sidebar-border/70 p-4 shadow-sm dark:border-sidebar-border">
                        <h2 class="text-sm font-medium text-gray-500">Totale progetti</h2>
                        <p class="mt-2 text-3xl font-bold">{{ totalProjects }}</p>
                    </div>

                    <div class="rounded-xl border border-sidebar-border/70 p-4 shadow-sm dark:border-sidebar-border">
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
                    <div class="rounded-xl border border-sidebar-border/70 p-4 shadow-sm dark:border-sidebar-border">
                        <h2 class="text-sm font-medium text-gray-500">Totale task</h2>
                        <p class="mt-2 text-3xl font-bold">{{ totalTasks }}</p>
                    </div>

                    <div class="rounded-xl border border-sidebar-border/70 p-4 shadow-sm dark:border-sidebar-border">
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

            <div class="grid gap-4" :class="props.isAdmin ? 'md:grid-cols-3' : 'md:grid-cols-2'">
                <div
                    v-if="props.isAdmin"
                    class="rounded-xl border border-sidebar-border/70 p-4 shadow-sm dark:border-sidebar-border"
                >
                    <h2 class="mb-4 text-lg font-semibold">Ultimi utenti aggiunti</h2>

                    <div v-if="latestUsers.length" class="space-y-3">
                        <div v-for="user in latestUsers" :key="user.id" class="rounded-lg border p-3">
                            <div class="font-medium">{{ user.name }}</div>
                            <div class="text-sm text-gray-500">{{ user.email }}</div>
                            <div class="text-xs text-gray-400">
                                Creato il: {{ new Date(user.created_at).toLocaleString('it-IT') }}
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Nessun utente presente.</p>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-4 shadow-sm dark:border-sidebar-border">
                    <h2 class="mb-4 text-lg font-semibold">Ultimi progetti aggiunti</h2>

                    <div v-if="latestProjects.length" class="space-y-3">
                        <div v-for="project in latestProjects" :key="project.id" class="rounded-lg border p-3">
                            <div class="font-medium">{{ project.name }}</div>
                            <div class="text-sm text-gray-500">
                                {{ project.description || 'Nessuna descrizione' }}
                            </div>
                            <div class="text-xs text-gray-400">
                                Creato il: {{ new Date(project.created_at).toLocaleString('it-IT') }}
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Nessun progetto presente.</p>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-4 shadow-sm dark:border-sidebar-border">
                    <h2 class="mb-4 text-lg font-semibold">Ultime task inserite</h2>

                    <div v-if="latestTasks.length" class="space-y-3">
                        <div v-for="task in latestTasks" :key="task.id" class="rounded-lg border p-3">
                            <div class="font-medium">{{ task.name }}</div>
                            <div class="text-sm text-gray-500">
                                {{ task.description || 'Nessuna descrizione' }}
                            </div>
                            <div class="text-xs text-gray-400">
                                Creata il: {{ new Date(task.created_at).toLocaleString('it-IT') }}
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Nessuna task presente.</p>
                </div>
            </div>

            <div class="grid gap-4 xl:grid-cols-3">
                <div class="rounded-xl border border-yellow-200 p-4 shadow-sm">
                    <h2 class="mb-4 text-lg font-semibold text-yellow-700">Task in scadenza</h2>

                    <div v-if="props.upcomingTasks?.length" class="space-y-3">
                        <div
                            v-for="task in props.upcomingTasks"
                            :key="task.id"
                            class="rounded-xl p-4 shadow-sm"
                            :class="getUpcomingCardClass(task.due_date)"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-semibold">{{ task.name }}</div>
                                    <div class="mt-1 text-sm text-gray-500">
                                        {{ task.description || 'Nessuna descrizione' }}
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full px-2 py-1 text-xs font-medium" :class="getStatusBadgeClass(task.status)">
                                        {{ formatStatus(task.status) }}
                                    </span>

                                    <span class="rounded-full px-2 py-1 text-xs font-medium" :class="getPriorityBadgeClass(task.priority)">
                                        {{ formatPriority(task.priority) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-3 flex flex-col gap-1 text-sm text-gray-500">
                                <div>
                                    Progetto:
                                    <span class="font-medium text-gray-700">
                                        {{ task.project?.name || 'Nessun progetto' }}
                                    </span>
                                </div>

                                <div :class="getDueDateClass(task.due_date)">
                                    Scadenza: {{ formatDueDate(task.due_date) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Nessuna task in scadenza.</p>
                </div>

                <div class="rounded-xl border border-red-200 p-4 shadow-sm">
                    <h2 class="mb-4 text-lg font-semibold text-red-700">Task scadute</h2>

                    <div v-if="props.overdueTasks?.length" class="space-y-3">
                        <div
                            v-for="task in props.overdueTasks"
                            :key="task.id"
                            class="rounded-xl p-4 shadow-sm"
                            :class="getOverdueCardClass()"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-semibold text-red-800">{{ task.name }}</div>
                                    <div class="mt-1 text-sm text-gray-600">
                                        {{ task.description || 'Nessuna descrizione' }}
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full px-2 py-1 text-xs font-medium" :class="getStatusBadgeClass(task.status)">
                                        {{ formatStatus(task.status) }}
                                    </span>

                                    <span class="rounded-full px-2 py-1 text-xs font-medium" :class="getPriorityBadgeClass(task.priority)">
                                        {{ formatPriority(task.priority) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-3 flex flex-col gap-1 text-sm text-gray-600">
                                <div>
                                    Progetto:
                                    <span class="font-medium text-gray-800">
                                        {{ task.project?.name || 'Nessun progetto' }}
                                    </span>
                                </div>

                                <div class="font-semibold text-red-700">
                                    Scadenza: {{ formatDueDate(task.due_date) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Nessuna task scaduta.</p>
                </div>

                <div class="rounded-xl border border-emerald-200 p-4 shadow-sm">
                    <h2 class="mb-4 text-lg font-semibold text-emerald-700">Task completate</h2>

                    <div v-if="props.completedTasks?.length" class="space-y-3">
                        <div
                            v-for="task in props.completedTasks"
                            :key="task.id"
                            class="rounded-xl p-4 shadow-sm"
                            :class="getCompletedCardClass()"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-semibold text-emerald-800">{{ task.name }}</div>
                                    <div class="mt-1 text-sm text-gray-600">
                                        {{ task.description || 'Nessuna descrizione' }}
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full px-2 py-1 text-xs font-medium" :class="getStatusBadgeClass(task.status)">
                                        {{ formatStatus(task.status) }}
                                    </span>

                                    <span class="rounded-full px-2 py-1 text-xs font-medium" :class="getPriorityBadgeClass(task.priority)">
                                        {{ formatPriority(task.priority) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-3 flex flex-col gap-1 text-sm text-gray-600">
                                <div>
                                    Progetto:
                                    <span class="font-medium text-gray-800">
                                        {{ task.project?.name || 'Nessun progetto' }}
                                    </span>
                                </div>

                                <div class="text-emerald-700 font-semibold">
                                    Completata
                                </div>

                                <div class="text-xs text-gray-500">
                                    Inserita il: {{ new Date(task.created_at).toLocaleString('it-IT') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Nessuna task completata.</p>
                </div>
            </div>
        </div>
    </MainLayout>
</template>