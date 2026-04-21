<script setup lang="ts">
import { Schema } from '@/avid/types/form';
import FormElement from './FormElement.vue';

const props = defineProps<{
    schema: Schema[];
    columns: {
        default?: number;
        sm?: number;
        md?: number;
        lg?: number;
        xl?: number;
        '2xl'?: number;
    };
}>();

const inertiaForm = defineModel<any>('inertiaForm');

const columns = computed(() => {
    let columns = 'grid-cols-1';

    if (props.columns.default) {
        columns = `grid-cols-${props.columns.default}`;
    }

    if (props.columns.sm) {
        columns = `${columns} sm:grid-cols-${props.columns.sm}`;
    }

    if (props.columns.md) {
        columns = `${columns} md:grid-cols-${props.columns.md}`;
    }

    if (props.columns.lg) {
        columns = `${columns} lg:grid-cols-${props.columns.lg}`;
    }

    if (props.columns.xl) {
        columns = `${columns} xl:grid-cols-${props.columns.xl}`;
    }

    if (props.columns['2xl']) {
        columns = `${columns} 2xl:grid-cols-${props.columns['2xl']}`;
    }

    return columns;
});
</script>

<template>
    <div class="grid gap-6" :class="columns">
        <template v-for="input in schema" :key="input.props.name">
            <FormElement v-model:inertia-form="inertiaForm" :schema="input" />
        </template>
    </div>
</template>
