<script setup lang="ts">
defineProps<{
    url: string;
}>();
</script>

<template>
    <a :href="url" target="_blank">
        <slot></slot>
    </a>
</template>
