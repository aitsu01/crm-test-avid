<script setup lang="ts">
defineProps<{
    url: string;
    modalSize?: 'sm' | 'lg' | 'xl' | '2xl' | '3xl' | '4xl' | '5xl' | '6xl';
}>();
</script>

<template>
    <ModalLink :href="url" :max-width="modalSize" :close-explicitly="true">
        <slot></slot>
    </ModalLink>
</template>
