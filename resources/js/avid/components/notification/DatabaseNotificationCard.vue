<script setup lang="ts">
import { DatabaseNotification } from '@/avid/types';
import { DateTime } from 'luxon';

const props = defineProps<{
    notification: DatabaseNotification;
}>();

const emit = defineEmits<{
    (e: 'reload'): void;
}>();

const formattedDate = computed(() => {
    return DateTime.fromISO(props.notification.created_at).toRelative();
});

const onMarkAsRead = (notification: DatabaseNotification) => {
    router.put(
        avidRoute('notifications.mark_as_read', notification),
        {},
        {
            onSuccess: () => {
                emit('reload');
            },
        },
    );
};
</script>

<template>
    <div class="flex w-full items-start gap-4 rounded-md border p-4">
        <div class="flex-shrink-0 pt-1">
            <i
                class="text-xl"
                :class="notification.icon"
                :style="{
                    color: notification.color,
                }"
            ></i>
        </div>

        <div class="min-w-0 flex-1 space-y-1">
            <p class="font-bold">{{ notification.title }}</p>
            <p class="text-sm text-surface-500 dark:text-surface-300">
                {{ formattedDate }}
            </p>

            <p v-if="notification.body" class="text-sm text-surface-500 dark:text-surface-300">
                {{ notification.body }}
            </p>
        </div>

        <div class="flex-shrink-0">
            <PrimeButton
                v-tooltip.top="$t('avid::notifications.mark_as_read')"
                icon="pi pi-times"
                variant="text"
                rounded
                size="small"
                severity="secondary"
                class="-mt-3 -mr-1"
                @click="onMarkAsRead(notification)"
            />
        </div>
    </div>
</template>
