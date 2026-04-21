<script setup lang="ts">
import { Schema } from '@/avid/types/form';
import FormElement from './FormElement.vue';

defineProps<{
    schema: Schema[];
}>();

const inertiaForm = defineModel<any>('inertiaForm');
</script>

<template>
    <div class="space-y-5">
        <template v-for="input in schema" :key="input.props.name">
            <FormElement v-model:inertia-form="inertiaForm" :schema="input" />
        </template>
    </div>
</template>
