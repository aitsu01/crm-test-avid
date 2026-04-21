<script setup lang="ts">
const isOpen = defineModel<boolean>('isOpen');

const emit = defineEmits<{
    (e: 'filter'): void;
    (e: 'clear'): void;
}>();

const active = computed(() => {
    return isOpen.value ? 'filters' : null;
});
</script>

<template>
    <div>
        <PrimeAccordion
            v-model:value="active"
            expandIcon="pi pi-plus"
            collapseIcon="pi pi-minus"
            :pt="{
                root: '!border-0',
            }"
        >
            <PrimeAccordionPanel
                value="filters"
                :pt="{
                    root: '!border-0',
                }"
            >
                <PrimeAccordionContent
                    :pt="{
                        content: '!border-0',
                    }"
                >
                    <div class="pt-4">
                        <div class="mb-2">
                            <slot name="button"></slot>
                        </div>

                        <div class="mb-6 grid gap-4 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                            <slot></slot>
                        </div>

                        <div class="flex gap-2">
                            <PrimeButton :label="$t('avid::table.filters.apply_filters')" @click="emit('filter')" />

                            <PrimeButton :label="$t('avid::table.filters.remove_filters')" severity="secondary" @click="emit('clear')" />
                        </div>
                    </div>
                </PrimeAccordionContent>
            </PrimeAccordionPanel>
        </PrimeAccordion>
    </div>
</template>
