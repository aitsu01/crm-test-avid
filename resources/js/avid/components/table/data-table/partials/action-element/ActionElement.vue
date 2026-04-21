<script setup lang="ts">
import { Action, ActionGroup } from '@/avid/types/table';

const props = defineProps<{
    action: Action | ActionGroup;
    size?: 'small' | 'large';
}>();

const emit = defineEmits<{
    (e: 'action', action: string): void;
}>();

const componentsMap: any = {
    Action: defineAsyncComponent(() => import('./partials/action/Action.vue')),
    ActionGroup: defineAsyncComponent(() => import('./partials/ActionGroup.vue')),
};

const componentName = computed(() => {
    return componentsMap[props.action.component] ?? null;
});
</script>

<template>
    <div>
        <component :is="componentName" v-bind="action" @action="emit('action', $event)" />
    </div>
</template>
