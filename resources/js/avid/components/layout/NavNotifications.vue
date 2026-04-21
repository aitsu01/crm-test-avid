<script setup lang="ts">
import { Avid } from '@/avid/types';
import { Button } from '@/components/ui/button';
import { Bell } from 'lucide-vue-next';

const unreadNotifications = computed(() => (usePage().props.avid as Avid).unreadNotifications);
</script>

<template>
    <ModalLink :href="avidRoute('notifications.modal')" class="relative">
        <PrimeBadge v-if="unreadNotifications > 0" :value="unreadNotifications" size="small" class="absolute -top-2 right-0" severity="warn" />

        <Button variant="ghost">
            <Bell class="ml-auto size-5" />
        </Button>
    </ModalLink>
</template>
