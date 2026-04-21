<script setup lang="ts">
import { Method } from '../../../enums';

const props = defineProps<{
    state: boolean;
    action?: string;
    method?: Method;
}>();

const onToggle = async () => {
    if (!props.action) {
        return;
    }

    router.visit(props.action, {
        method: props.method ?? 'post',
        data: {},
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <div>
        <PrimeToggleSwitch :model-value="state" @update:model-value="onToggle" />
    </div>
</template>
