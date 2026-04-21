<script setup lang="ts">
import HeadingSmall from '@/avid/components/layout/HeadingSmall.vue';
import { Schema } from '@/avid/types/form';
import FormElement from './FormElement.vue';

defineProps<{
    schema: Schema[];
    heading?: string;
    description?: string;
    icon?: string;
    aside?: boolean;
}>();

const inertiaForm = defineModel<any>('inertiaForm');
</script>

<template>
    <div
        :class="{
            'grid gap-x-6 md:grid-cols-3': aside,
        }"
    >
        <div v-if="aside" class="mb-4 space-y-1 md:mb-0">
            <h3 class="text-lg font-semibold">{{ heading }}</h3>
            <h6 v-if="description" class="text-gray-500">{{ description }}</h6>
        </div>

        <PrimeCard
            :class="{
                'md:col-span-2': aside,
            }"
        >
            <template v-if="heading && !aside" #header>
                <div class="flex items-center gap-5 border-b px-5 py-3">
                    <div v-if="icon" class="flex-shrink-0 pt-1">
                        <i class="text-2xl text-gray-400" :class="icon"></i>
                    </div>

                    <HeadingSmall :title="heading" :description="description" class="min-w-0 flex-1" />
                </div>
            </template>

            <template #content>
                <div class="space-y-5">
                    <template v-for="input in schema" :key="input.props.name">
                        <FormElement v-model:inertia-form="inertiaForm" :schema="input" />
                    </template>
                </div>
            </template>
        </PrimeCard>
    </div>
</template>
