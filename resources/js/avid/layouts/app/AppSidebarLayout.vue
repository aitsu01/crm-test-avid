<script setup lang="ts">
import AppContent from '@/avid/components/layout/AppContent.vue';
import AppShell from '@/avid/components/layout/AppShell.vue';
import AppSidebar from '@/avid/components/layout/AppSidebar.vue';
import AppSidebarHeader from '@/avid/components/layout/AppSidebarHeader.vue';
import Heading from '@/avid/components/layout/Heading.vue';
import { Avid } from '@/avid/types';

const page = computed(() => (usePage().props.avid as Avid).page);

const WidgetBuilder = defineAsyncComponent(() => import('@/avid/components/widget/WidgetBuilder.vue'));

const maxSize = computed(() => {
    switch (page.value.size) {
        case 'xs':
            return 'max-w-screen-xs';
        case 'sm':
            return 'max-w-screen-sm';
        case 'md':
            return 'max-w-screen-md';
        case 'lg':
            return 'max-w-screen-lg';
        case 'xl':
            return 'max-w-screen-xl';
        case 'xxl':
            return 'max-w-screen-2xl';
        case 'xxxl':
            return 'max-w-screen-3xl';
        default:
            return 'w-full';
    }
});

const classes = computed(() => {
    if (page.value.size === 'full') {
        return [maxSize.value];
    }

    return [maxSize.value, 'px-4 sm:px-6 py-6 mx-auto w-full'];
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar>
            <template v-if="$slots.logo" #logo>
                <slot name="logo"></slot>
            </template>

            <template v-if="$slots.sidebarHeader" #sidebarHeader>
                <slot name="sidebarHeader"></slot>
            </template>

            <template v-if="$slots.sidebarFooter" #sidebarFooter>
                <slot name="sidebarFooter"></slot>
            </template>
        </AppSidebar>

        <AppContent variant="sidebar">
            <AppSidebarHeader>
                <template v-if="$slots.actions" #actions>
                    <slot name="actions"></slot>
                </template>
            </AppSidebarHeader>

            <div :class="classes">

                <slot v-if="$slots.header" name="header"></slot>

                <Heading v-else-if="!page.hideTitleBar && page.title" :title="page.title" :description="page.subtitle" />

                <div v-if="page.widgets.length" class="mb-8">
                    <WidgetBuilder :schema="page.widgets" />
                </div>

                <slot />
            </div>
        </AppContent>
    </AppShell>
</template>
