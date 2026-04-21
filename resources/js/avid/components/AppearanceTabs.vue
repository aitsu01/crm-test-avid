<script setup lang="ts">
import { useAppearance } from '@/avid/composables/useAppearance';
import { Monitor, Moon, Sun } from 'lucide-vue-next';

const { appearance, updateAppearance } = useAppearance();

const tabs = computed(() => [
    { value: 'light', Icon: Sun, label: 'avid::settings.light' },
    { value: 'dark', Icon: Moon, label: 'avid::settings.dark' },
    { value: 'system', Icon: Monitor, label: 'avid::settings.system' },
]);
</script>

<template>
    <div class="inline-flex gap-1 rounded-lg bg-neutral-100 p-1 dark:bg-neutral-800">
        <button
            v-for="{ value, Icon, label } in tabs"
            :key="value"
            @click="updateAppearance(value)"
            :class="[
                'flex items-center rounded-md px-3.5 py-1.5 transition-colors',
                appearance === value
                    ? 'bg-white shadow-xs dark:bg-neutral-700 dark:text-neutral-100'
                    : 'text-neutral-500 hover:bg-neutral-200/60 hover:text-black dark:text-neutral-400 dark:hover:bg-neutral-700/60',
            ]"
        >
            <component :is="Icon" class="-ml-1 h-5 w-5" />
            <span class="ml-1.5">{{ $t(label) }}</span>
        </button>
    </div>
</template>
