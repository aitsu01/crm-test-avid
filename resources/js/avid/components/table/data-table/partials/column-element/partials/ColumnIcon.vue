<script setup lang="ts">
import { Size } from '../../../enums';

const props = defineProps<{
    icon: string;
    color?: any;
    size?: Size | string;
}>();

const colorClass = computed(() => {
    if (!props.color) {
        return '';
    }

    switch (props.color) {
        case 'primary':
            return 'text-primary';
        case 'secondary':
            return 'text-secondary';
        case 'success':
            return 'text-success';
        case 'warn':
            return 'text-warn';
        case 'error':
            return 'text-error';
        case 'info':
            return 'text-info';
        case 'contract':
            return 'text-contract';
        default:
            return '';
    }
});

const sizeClass = computed(() => {
    if (!props.size) {
        return '';
    }

    switch (props.size) {
        case Size.ExtraSmall:
        case 'xs':
            return '!text-xs';
        case Size.Small:
        case 'sm':
            return '!text-sm';
        case Size.Medium:
        case 'md':
            return '!text-md';
        case Size.Large:
        case 'lg':
            return '!text-lg';
        case Size.ExtraLarge:
        case 'xl':
            return '!text-xl';
        case Size.TwoExtraLarge:
        case '2xl':
            return '!text-2xl';
        default:
            return '';
    }
});
</script>

<template>
    <div>
        <i :class="[icon, colorClass, sizeClass]"></i>
    </div>
</template>
