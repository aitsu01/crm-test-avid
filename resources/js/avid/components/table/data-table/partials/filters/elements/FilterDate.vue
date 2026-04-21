<script setup lang="ts">
import dayjs from 'dayjs';

interface Props {
    name: string;
    label?: string;
    clause?: string;
}

const props = withDefaults(defineProps<Props>(), {});

const emit = defineEmits<{
    (e: 'filter'): void;
}>();

const model = defineModel<string | (string | null)[] | null | undefined>();

const date = computed<Date | (Date | null)[] | null>(() => {
    if (!model.value) return null;

    if (Array.isArray(model.value)) {
        return model.value.map((d) => (d ? new Date(d) : null));
    }

    return new Date(model.value);
});

const selectionMode = computed(() => {
    if (!props.clause) {
        return undefined;
    }

    if (['between', 'not_between'].includes(props.clause)) return 'range';

    return undefined;
});

const manualInput = computed(() => {
    return selectionMode.value !== 'range';
});

const onUpdate = (value: Date | Date[] | (Date | null)[] | null | undefined) => {
    if (!value) {
        model.value = null;
        emit('filter');
        return;
    }

    if (Array.isArray(value)) {
        model.value = value.map((d) => (d ? dayjs(d).format('YYYY-MM-DD') : null));
        if (model.value.length === 2) {
            emit('filter');
        }
        return;
    }

    model.value = dayjs(value).format('YYYY-MM-DD');

    emit('filter');
};

const onClear = () => {
    model.value = null;
    emit('filter');
};

watch(selectionMode, () => {
    model.value = null;
});
</script>

<template>
    <PrimeDatePicker
        :id="name"
        :model-value="date"
        :name="name"
        fluid
        show-icon
        icon-display="input"
        :show-button-bar="manualInput"
        class="!w-full"
        :selection-mode="selectionMode"
        :manual-input="manualInput"
        date-format="dd/mm/yy"
        @update:model-value="onUpdate"
        @clear-click="onClear"
    />
</template>
