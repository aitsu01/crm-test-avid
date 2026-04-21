<script setup lang="ts">
import { Field, HasPlaceholder, HasSize } from '@/avid/types/form';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder {
    mask?: string;
    autoClear?: boolean;
    slotChar?: string;
    unmask?: boolean;
}

withDefaults(defineProps<Props>(), {});

const model = defineModel<string | null | undefined>();
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeInputMask
                :id="name"
                v-model="model"
                :name="name"
                :size="size"
                fluid
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :mask="mask"
                :auto-clear="autoClear"
                :slot-char="slotChar"
                :unmask="unmask"
            />
        </template>
    </FormControl>
</template>
