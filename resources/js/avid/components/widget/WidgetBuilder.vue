<script setup lang="ts">
import { Schema } from '@/avid/types/widget';
import WidgetElement from './WidgetElement.vue';

const props = defineProps<{
    schema: Schema[];
}>();
</script>

<template>
    <div class="space-y-5">
        <template v-for="element in schema" :key="element.id">
            <WidgetElement :schema="element" />
        </template>
    </div>
</template>
