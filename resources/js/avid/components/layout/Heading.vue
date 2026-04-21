<script setup lang="ts">
interface Props {
    title: string;
    description?: string | null;
}

defineProps<Props>();
</script>

<template>
    <div class="mb-8 space-y-1.5">
        <h2 class="text-2xl font-semibold tracking-tight">{{ title }}</h2>
        <p v-if="description" class="text-muted-foreground">
            {{ description }}
        </p>
    </div>
</template>
