<script setup lang="ts">
const props = withDefaults(
    defineProps<{
        name: string;
        label?: string;
        required?: boolean | null;
        error?: string | null;
    }>(),
    {},
);

const invalid = computed(() => !!props.error);
</script>

<template>
    <div class="flex w-full flex-col gap-2">
        <label v-if="label" :for="name">{{ label }} <span v-if="required" class="text-red-600">*</span></label>

        <slot :invalid="invalid" />

        <PrimeMessage v-if="error" severity="error" size="small" variant="simple">
            {{ error }}
        </PrimeMessage>
    </div>
</template>
