<script setup lang="ts">
import Breadcrumbs from '@/avid/components/layout/Breadcrumbs.vue';
import type { Avid, Breadcrumb } from '@/avid/types';
import { SidebarTrigger } from '@/components/ui/sidebar';
import NavNotifications from './NavNotifications.vue';
import NavUser from './NavUser.vue';
import NavLocale from './NavLocale.vue';

const settings = computed(() => (usePage().props.avid as Avid).settings);

const breadcrumbs = computed<Breadcrumb[]>(() => (usePage().props.avid as Avid).page.breadcrumbs);
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 bg-sidebar-header px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
        <div class="flex flex-1 items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <SidebarTrigger class="-ml-1" />
                <template v-if="breadcrumbs && breadcrumbs.length > 0">
                    <Breadcrumbs :breadcrumbs="breadcrumbs" />
                </template>
            </div>

            <div class="flex items-center gap-2">
                <template v-if="$slots.actions">
                    <slot name="actions"></slot>
                </template>

                <NavLocale v-if="settings.canUpdateLocale" />

                <NavNotifications v-if="settings.isNotificationEnabled" />

                <NavUser />
            </div>
        </div>
    </header>
</template>
