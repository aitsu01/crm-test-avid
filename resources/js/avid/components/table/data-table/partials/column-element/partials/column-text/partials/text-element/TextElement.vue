<script setup lang="ts">
import { Weight } from '@/avid/components/table/data-table/enums';
import BadgeContainer from './partials/BadgeContainer.vue';
import InnerText from './partials/InnerText.vue';

const props = withDefaults(
    defineProps<{
        state: any;
        isBadge?: boolean;
        canWrap?: boolean;
        color?: any;
        icon?: string;
        iconPosition?: 'before' | 'after';
        iconColor?: any;
        weight?: Weight | string;
        lineClamp?: number;
        isHtml?: boolean;
    }>(),
    {
        iconPosition: 'before',
    },
);

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
        case 'warning':
            return 'text-warn';
        case 'error':
        case 'danger':
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
    <template v-if="isBadge">
        <BadgeContainer v-if="state !== null" :color="color">
            <InnerText
                :state="state"
                :can-wrap="canWrap"
                :icon="icon"
                :icon-position="iconPosition"
                :icon-color="iconColor"
                :weight="weight"
                :line-clamp="lineClamp"
                :is-html="isHtml"
            />
        </BadgeContainer>
    </template>

    <template v-else>
        <InnerText
            :state="state"
            :can-wrap="canWrap"
            :icon="icon"
            :icon-position="iconPosition"
            :icon-color="iconColor"
            :weight="weight"
            :line-clamp="lineClamp"
            :is-html="isHtml"
            :class="colorClass"
        />
    </template>
</template>
