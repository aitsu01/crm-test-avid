<script setup lang="ts">
import { Schema } from '@/avid/types/form';
import LayoutStep from './LayoutStep.vue';

defineProps<{
    schema: Schema[];
    linear?: boolean;
    allowSubmit?: boolean;
}>();

const inertiaForm = defineModel<any>('inertiaForm');
</script>

<template>
    <PrimeCard
        :pt="{
            body: {
                class: 'p-0',
            },
        }"
    >
        <template #content>
            <PrimeStepper :value="1" :linear="linear">
                <div class="px-4 pt-4">
                    <PrimeStepList>
                        <template v-for="(input, i) in schema" :key="i">
                            <PrimeStep :value="i + 1">{{ input.props.heading }}</PrimeStep>
                        </template>
                    </PrimeStepList>
                </div>

                <PrimeDivider />

                <PrimeStepPanels class="!p-0">
                    <template v-for="(input, i) in schema" :key="i">
                        <PrimeStepPanel v-slot="{ activateCallback }" :value="i + 1" class="bg-transparent">
                            <div class="px-6 pt-4 pb-6">
                                <LayoutStep v-model:inertia-form="inertiaForm" :schema="input.props.schema" />
                            </div>

                            <PrimeDivider />

                            <div class="flex justify-between px-4 pb-4">
                                <PrimeButton
                                    v-if="i > 0"
                                    :label="$t('avid::form.back')"
                                    severity="secondary"
                                    icon="pi pi-arrow-left"
                                    @click="activateCallback(i)"
                                />
                                <div v-else></div>

                                <PrimeButton
                                    v-if="i < schema.length - 1"
                                    :label="$t('avid::form.next')"
                                    icon="pi pi-arrow-right"
                                    iconPos="right"
                                    @click="activateCallback(i + 2)"
                                />

                                <PrimeButton v-else-if="allowSubmit" :label="$t('avid::form.save')" type="submit" :loading="inertiaForm.processing" />
                            </div>
                        </PrimeStepPanel>
                    </template>
                </PrimeStepPanels>
            </PrimeStepper>
        </template>
    </PrimeCard>
</template>
