<script setup lang="ts">
import { Field, HasPlaceholder, HasSize } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder {
    trueValue?: any;
    falseValue?: any;
}

withDefaults(defineProps<Props>(), {
    trueValue: true,
    falseValue: false,
});

const model = defineModel<boolean | null | undefined>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <div class="flex items-center gap-2">
                <PrimeCheckbox
                    v-model="model"
                    :input-id="name"
                    binary
                    :size="size"
                    :disabled="disabled"
                    :readonly="readonly"
                    :invalid="invalid"
                    :true-value="trueValue"
                    :false-value="falseValue"
                />

                <label v-if="placeholder" :for="name">{{ placeholder }}</label>
            </div>
        </template>
    </FormControl>
</template>
