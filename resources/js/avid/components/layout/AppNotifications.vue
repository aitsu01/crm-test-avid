<script setup lang="ts">
import { Notification, NotificationProgress, Notivue, NotivueSwipe, NotivueTheme, pastelTheme } from 'notivue';

const theme: NotivueTheme = {
    ...pastelTheme,
    '--nv-min-width': '300px',
};
</script>

<template>
    <Notivue v-slot="item">
        <NotivueSwipe :item="item">
            <Notification :item="item" :theme="theme">
                <NotificationProgress :item="item" />
            </Notification>
        </NotivueSwipe>
    </Notivue>
</template>
