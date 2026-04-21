<script setup lang="ts">
const props = defineProps<{
    color?: any;
}>()

const severity = computed(() => {
    switch (props.color) {
        case 'warning':
            return 'warn';
        case 'danger':
            return 'error';
        default:
            return props.color ?? 'info';
    }
})
</script>

<template>
    <PrimeMessage
        size="small"
        class="!inline-block"
        :severity="severity ?? 'info'"
        :pt="{
            content: {
                class: 'px-1.5 py-0',
            },
        }"
    >
        <slot></slot>
    </PrimeMessage>
</template>
