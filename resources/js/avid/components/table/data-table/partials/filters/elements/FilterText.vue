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
</script>

<template>
    <PrimeInputText :id="name" v-model="model" :name="name" fluid @keyup.enter="emit('filter')" @input="emit('filter')" />
</template>
