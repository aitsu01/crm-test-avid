<script setup lang="ts">
import AppNotifications from '@/avid/components/layout/AppNotifications.vue';
import AppLayout from '@/avid/layouts/app/AppSidebarLayout.vue';
import type { Avid } from '@/avid/types';
import ConfirmDialog from 'primevue/confirmdialog';

const avid: Avid = computed(() => usePage().props.avid as Avid);

</script>

<template>
    <Head>
        <title>{{ avid.page.title }}</title>
        <meta v-if="avid.page.description" name="description" :content="avid.page.description" />
        <meta v-if="avid.page.keywords" name="keywords" :content="avid.page.keywords" />
    </Head>

    <AppLayout>
        <AppNotifications />

        <template v-if="$slots.logo" #logo>
            <slot name="logo"></slot>
        </template>

        <template v-if="$slots.sidebarHeader" #sidebarHeader>
            <slot name="sidebarHeader"></slot>
        </template>
        
        <template v-if="$slots.sidebarFooter" #sidebarFooter>
            <slot name="sidebarFooter"></slot>
        </template>

        <template v-if="$slots.actions" #actions>
            <slot name="actions"></slot>
        </template>

        <template v-if="$slots.header" #header>
            <slot name="header"></slot>
        </template>

        <slot />

        <ConfirmDialog />
    </AppLayout>
</template>
