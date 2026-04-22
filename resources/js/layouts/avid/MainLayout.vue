<script setup lang="ts">
import AvidLayout from '@/avid/layouts/MainLayout.vue';
import { router } from '@inertiajs/vue3';


let notificationsInterval: number | undefined;

onMounted(() => {
    notificationsInterval = window.setInterval(() => {
        if (document.visibilityState !== 'visible') {
            return;
        }

        router.reload({
            preserveScroll: true,
            preserveState: true,
        });
    }, 5000);
});

onUnmounted(() => {
    if (notificationsInterval) {
        clearInterval(notificationsInterval);
    }
});
</script>

<template>
    <AvidLayout>
        <slot />
    </AvidLayout>
</template>