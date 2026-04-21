<script setup lang="ts">

const props = defineProps<{
    loading: boolean
    placeholderHeight: string
}>()

</script>

<template>
    <PrimeCard v-if="loading" class="relative overflow-hidden" pt:body="p-0">
        <template #content>
            <div class="flex" :style="{
                height: placeholderHeight
            }">
                <PrimeSkeleton class="h-full! w-full"/>
            </div>
        </template>
    </PrimeCard>

    <PrimeCard v-else class="overflow-hidden">
        <template v-if="$slots.header" #header>
            <slot name="header"></slot>
        </template>

        <template #content>
            <slot></slot>
        </template>
    </PrimeCard>
</template>