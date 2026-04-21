<script setup lang="ts">
import { Column } from '@/avid/types/table';

const props = defineProps<{
    column: Column;
    data: any;
    size?: 'small' | 'large';
}>();

const componentsMap: any = {
    ColumnText: defineAsyncComponent(() => import('./partials/column-text/ColumnText.vue')),
    ColumnIcon: defineAsyncComponent(() => import('./partials/ColumnIcon.vue')),
    ColumnColor: defineAsyncComponent(() => import('./partials/ColumnColor.vue')),
    ColumnImage: defineAsyncComponent(() => import('./partials/ColumnImage.vue')),
    ColumnToggle: defineAsyncComponent(() => import('./partials/ColumnToggle.vue')),
    ColumnRating: defineAsyncComponent(() => import('./partials/ColumnRating.vue')),
};

const componentName = computed(() => {
    return componentsMap[props.column.component] ?? null;
});

const hasRecordUrl = computed(() => {
    return props.data.recordUrl && props.column.component !== 'ColumnToggle' && props.column.component !== 'ColumnImage';
});

const shouldOpenRecordUrlInNewTab = computed(() => {
    return hasRecordUrl.value && props.data.shouldOpenRecordUrlInNewTab;
});

const shouldOpenRecordUrlInModal = computed(() => {
    return hasRecordUrl.value && props.data.shouldOpenRecordUrlInModal;
});

const paddingVertical = computed(() => {
    if (props.column.component === 'ColumnImage') {
        return 'py-1';
    }

    switch (props.size) {
        case 'small':
            return 'py-1';
        case 'large':
            return 'py-4';
        default:
            return 'py-3';
    }
});
const paddingHorizontal = computed(() => {
    switch (props.size) {
        case 'small':
            return 'px-2';
        case 'large':
            return 'px-5';
        default:
            return 'px-4';
    }
});
</script>

<template>
    <template v-if="hasRecordUrl"> 
        <a v-if="shouldOpenRecordUrlInNewTab" :href="data.recordUrl" target="_blank" class="flex h-full w-full items-center" :class="[paddingHorizontal, paddingVertical]">
            <component :is="componentName" :column="column" v-bind="data[column.name]" />
        </a>
        <ModalLink v-else-if="shouldOpenRecordUrlInModal" :href="data.recordUrl" class="flex h-full w-full items-center" :class="[paddingHorizontal, paddingVertical]">
            <component :is="componentName" :column="column" v-bind="data[column.name]" />
        </ModalLink>
        <Link v-else :href="data.recordUrl" class="flex h-full w-full items-center" :class="[paddingHorizontal, paddingVertical]">
            <component :is="componentName" :column="column" v-bind="data[column.name]" />
        </Link>
    </template>
    <div v-else class="flex h-full w-full items-center" :class="[paddingHorizontal, paddingVertical]">
        <component :is="componentName" :column="column" v-bind="data[column.name]" />
    </div>
</template>

<style scoped>
/* .column-element {
    padding: var(--p-datatable-body-cell-padding);
} */
</style>
