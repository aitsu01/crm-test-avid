<script setup lang="ts">
defineProps<{
    url: string;
}>();
</script>

<template>
    <Link :href="url">
        <slot></slot>
    </Link>
</template>
