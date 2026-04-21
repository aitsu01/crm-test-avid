<script setup lang="ts">
import { Weight } from '@/avid/components/table/data-table/enums';

const props = defineProps<{
    state: any;
    canWrap?: boolean;
    icon?: string;
    iconPosition?: 'before' | 'after';
    iconColor?: any;
    weight?: Weight | string;
    lineClamp?: number;
    isHtml?: boolean;
}>();

const lineClampSyle = computed(() => {
    if (!props.lineClamp) {
        return '';
    }

    return `overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: ${props.lineClamp};`;
});

const weightClass = computed(() => {
    switch (props.weight) {
        case Weight.Thin:
        case 'thin':
            return '!font-thin';
        case Weight.ExtraLight:
        case 'extralight':
            return '!font-extralight';
        case Weight.Light:
        case 'light':
            return '!font-light';
        case Weight.Normal:
        case 'normal':
            return '!font-normal';
        case Weight.Medium:
        case 'medium':
            return '!font-medium';
        case Weight.SemiBold:
        case 'semibold':
            return '!font-semibold';
        case Weight.Bold:
        case 'bold':
            return '!font-bold';
        case Weight.ExtraBold:
        case 'extrabold':
            return '!font-extrabold';
        case Weight.Black:
        case 'black':
            return '!font-black';
        default:
            return '';
    }
});

const iconColorClass = computed(() => {
    if (!props.iconColor) {
        return '';
    }

    switch (props.iconColor) {
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
</script>

<template>
    <div
        :class="[
            {
                'inline-flex items-center gap-2': icon,
            },
        ]"
    >
        <i v-if="icon && iconPosition === 'before'" class="text-sm" :class="[icon, iconColorClass]"></i>
        <span
            :class="[
                {
                    'truncate whitespace-nowrap': !canWrap,
                },
                weightClass,
            ]"
            :style="[lineClampSyle]"
        >
            <span v-if="isHtml" v-html="state"></span>
            <span v-else>
                {{ state }}
            </span>
        </span>

        <i v-if="icon && iconPosition === 'after'" class="text-sm" :class="[icon, iconColorClass]"></i>
    </div>
</template>
