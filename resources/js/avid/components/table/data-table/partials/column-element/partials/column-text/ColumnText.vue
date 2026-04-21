<script setup lang="ts">
import { Column } from '@/avid/types/table';
import TextElement from './partials/text-element/TextElement.vue';

defineProps<{
    column: Column;
    state: any;
    descriptionAbove?: string;
    descriptionBelow?: string;
    isBulleted?: boolean;
    isListWithLineBreaks?: boolean;
}>();
</script>

<template>
    <div class="space-y-1">
        <p v-if="descriptionAbove" class="text-muted-foreground">
            {{ descriptionAbove }}
        </p>

        <ul
            class="flex flex-wrap gap-x-3 gap-y-1"
            :class="{
                'flex-col': isListWithLineBreaks,
                'list-disc': isBulleted,
            }"
        >
            <template v-for="(item, i) in state" :key="i">
                <li>
                    <TextElement v-bind="item" />
                </li>
                <li v-if="i !== state.length - 1 && !isBulleted && !isListWithLineBreaks && !item.isBadge && !item.icon">|</li>
            </template>
        </ul>

        <p v-if="descriptionBelow" class="text-muted-foreground">
            {{ descriptionBelow }}
        </p>
    </div>
</template>
