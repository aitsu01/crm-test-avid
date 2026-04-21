<script setup lang="ts">
interface Props {
    name: string;
    label?: string;
}

withDefaults(defineProps<Props>(), {});

const emit = defineEmits<{
    (e: 'filter'): void;
}>();

const model = defineModel<string | null | undefined>();

const options = [
    {
        label: 'Vero',
        key: true,
    },
    {
        label: 'Falso',
        key: false,
    },
];
</script>

<template>
    <PrimeSelect
        :id="name"
        v-model="model"
        :name="name"
        fluid
        :options="options"
        option-label="label"
        option-value="key"
        show-clear
        @change="emit('filter')"
    />
</template>
