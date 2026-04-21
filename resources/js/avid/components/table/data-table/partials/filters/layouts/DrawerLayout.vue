<script setup lang="ts">
const isOpen = defineModel<boolean>('isOpen');

const emit = defineEmits<{
    (e: 'filter'): void;
    (e: 'clear'): void;
}>();
</script>

<template>
    <div>
        <PrimeDrawer v-model:visible="isOpen" :header="$t('avid::table.filters.filters')" position="right">
            <div class="mb-2">
                <slot name="button"></slot>
            </div>

            <slot></slot>

            <template #footer>
                <div class="flex gap-2">
                    <PrimeButton :label="$t('avid::table.filters.apply_filters')" @click="emit('filter')" />

                    <PrimeButton :label="$t('avid::table.filters.remove_filters')" severity="secondary" @click="emit('clear')" />
                </div>
            </template>
        </PrimeDrawer>
    </div>
</template>
