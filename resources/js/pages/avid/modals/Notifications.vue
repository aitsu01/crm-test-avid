<script setup lang="ts">
import DatabaseNotificationCard from '@/avid/components/notification/DatabaseNotificationCard.vue';
import { DatabaseNotification } from '@/avid/types';

defineProps<{
    notifications: DatabaseNotification[];
}>();

const modalRef = ref<any>(null);

const onReload = () => {
    modalRef.value.reload({ only: ['notifications'] });
};

const onMarkAllAsRead = () => {
    router.put(
        avidRoute('notifications.mark_all_as_read'),
        {},
        {
            onSuccess: () => {
                onReload();
            },
        },
    );
};
</script>

<template>
    <Modal ref="modalRef" slideover>
        <div class="mb-6 space-y-3">
            <div class="flex items-start gap-2">
                <h2 class="text-2xl font-semibold tracking-tight">{{ $t('avid::notifications.notifications') }}</h2>

                <PrimeBadge v-if="notifications.length" :value="notifications.length" severity="warn" size="small" />
            </div>

            <PrimeButton
                v-if="notifications.length"
                :label="$t('avid::notifications.mark_everything_as_read')"
                variant="link"
                class="!p-0"
                @click="onMarkAllAsRead"
            />
        </div>

        <div v-if="notifications.length" class="space-y-3">
            <template v-for="notification in notifications" :key="notification.id">
                <DatabaseNotificationCard :notification="notification" @reload="onReload" />
            </template>
        </div>

        <div v-else class="flex flex-col items-center justify-center gap-5 py-8">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-50 text-gray-400 dark:bg-muted dark:text-gray-300">
                <i class="pi pi-bell-slash text-2xl"></i>
            </div>

            <h5 class="text-gray-500 dark:text-gray-300">{{ $t('avid::notifications.no_notification_received') }}</h5>
        </div>
    </Modal>
</template>
