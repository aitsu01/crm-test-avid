<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
}

defineProps<Props>();
</script>

<template>
    <header class="space-y-1">
        <h3 class="text-lg font-medium">{{ title }}</h3>

        <p v-if="description" class="text-base text-muted-foreground">
            {{ description }}
        </p>
    </header>
</template>
