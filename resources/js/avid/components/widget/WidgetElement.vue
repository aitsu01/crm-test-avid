<script setup lang="ts">
import { Schema } from '@/avid/types/widget';

const props = defineProps<{
    schema: Schema;
}>();

const componentsMap: any = {
    WidgetStat: defineAsyncComponent(() => import('./WidgetStat.vue')),
    WidgetChart: defineAsyncComponent(() => import('./WidgetChart.vue')),
    WidgetList: defineAsyncComponent(() => import('./WidgetList.vue')),
    LayoutGrid: defineAsyncComponent(() => import('./LayoutGrid.vue')),
    WidgetFragment: defineAsyncComponent(() => import('./WidgetFragment.vue')),
}

const componentName = computed(() => {
    return componentsMap[props.schema.component] ?? null;
});
</script>

<template>
    <component :is="componentName" :schema="schema" />
</template>
