<script setup lang="ts">
import { Schema } from '@/avid/types/form';
import FormElement from './FormElement.vue';

defineProps<{
    schema: Schema[];
    heading?: string;
    toggleable?: boolean;
    collapsed?: boolean;
}>();

const inertiaForm = defineModel<any>('inertiaForm');
</script>

<template>
    <PrimeFieldset :legend="heading" :toggleable="toggleable" :collapsed="collapsed">
        <div class="space-y-5">
            <template v-for="input in schema" :key="input.props.name">
                <FormElement v-model:inertia-form="inertiaForm" :schema="input" />
            </template>
        </div>
    </PrimeFieldset>
</template>
