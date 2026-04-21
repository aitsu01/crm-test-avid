<script setup lang="ts">
import { Schema } from '@/avid/types/widget';
import { InertiaFragment } from '../fragment';

const props = defineProps<{
    schema: Schema
}>()

</script>

<template>
    <InertiaFragment :route="route('widgets.show', {
        widget: schema.id,
        ...(schema.params ?? {})
    })">
        <template #loading>
            <PrimeCard class="relative overflow-hidden" pt:body="p-0">
                <template #content>
                    <div class="flex" :style="{
                        height: schema.placeholderHeight
                    }">
                        <PrimeSkeleton class="h-full! w-full"/>
                    </div>
                </template>
            </PrimeCard>
        </template>
    </InertiaFragment>
</template>