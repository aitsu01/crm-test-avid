<script setup lang="ts">
import AppContent from '@/avid/components/layout/AppContent.vue';
import AppHeader from '@/avid/components/layout/AppHeader.vue';
import AppShell from '@/avid/components/layout/AppShell.vue';
import type { BreadcrumbItemType } from '@/avid/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell class="flex-col">
        <AppHeader :breadcrumbs="breadcrumbs" />
        <AppContent>
            <slot />
        </AppContent>
    </AppShell>
</template>
