<script setup lang="ts">
withDefaults(
    defineProps<{
        label: string
        value?: string | null | undefined
    }>(),
    {
        value: undefined,
    },
)
</script>

<template>
    <div class="flex flex-col gap-1">
        <p class="font-medium text-muted-foreground">{{ label }}</p>

        <div v-if="$slots.default">
            <slot />
        </div>

        <p v-else>{{ value }}</p>
    </div>
</template>
