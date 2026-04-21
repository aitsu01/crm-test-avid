<script setup lang="ts">
interface Props {
    name: string;
    label?: string;
    clause?: string;
}

const props = withDefaults(defineProps<Props>(), {});

const emit = defineEmits<{
    (e: 'filter'): void;
}>();

const model = defineModel<number | (number | null | undefined)[] | null | undefined>();

const selectionMode = computed(() => {
    if (!props.clause) {
        return undefined;
    }

    if (['between', 'not_between'].includes(props.clause)) return 'range';

    return undefined;
});

watch(selectionMode, (value) => {
    if (value === 'range') {
        model.value = [null, null];
    } else {
        model.value = null;
    }
});
</script>

<template>
    <div v-if="selectionMode === 'range' && Array.isArray(model)" class="flex items-center gap-2">
        <PrimeInputNumber :id="name" v-model="model[0]" :name="name" fluid @keyup.enter="emit('filter')" />

        <PrimeInputNumber :id="name" v-model="model[1]" :name="name" fluid @keyup.enter="emit('filter')" />
    </div>

    <PrimeInputNumber v-else :id="name" v-model="model" :name="name" fluid @keyup.enter="emit('filter')" @input="emit('filter')" />
</template>
