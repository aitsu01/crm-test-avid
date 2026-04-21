<script setup lang="ts">
import { Action } from '@/avid/types/table';

const props = defineProps<{
    actions: Action[];
    icon: string;
    label?: string;
    showLabel?: boolean;
    selection: (number | string)[];
}>();

const confirm = useConfirm();

const menu = ref();

const runAction = (action: Action) => {
    if (!action.url) {
        return;
    }

    router.visit(action.url, {
        method: action.method,
        data: {
            selection: action.method !== 'get' ? props.selection : undefined,
        },
        preserveScroll: true,
        preserveState: true,
    });
};

const items = computed(() => {
    return [
        {
            label: t('avid::table.actions'),
            items: props.actions.map((action) => {
                return {
                    label: action.label,
                    icon: action.icon,
                    command: () => {
                        if (action.requiresConfirmation) {
                            confirm.require({
                                message: action.confirmationMessage,
                                header: 'Attenzione',
                                icon: 'pi pi-exclamation-triangle',
                                rejectProps: {
                                    label: 'Annulla',
                                    severity: 'secondary',
                                    outlined: true,
                                },
                                acceptProps: {
                                    label: 'Conferma',
                                    severity: 'danger',
                                },
                                accept: () => {
                                    runAction(action);
                                },
                            });
                        } else {
                            runAction(action);
                        }
                    },
                };
            }),
        },
    ];
});

const onToggle = (event: any) => {
    menu.value.toggle(event);
};
</script>

<template>
    <div>
        <PrimeButton
            v-tooltip.top="showLabel ? (label ?? undefined) : label"
            :label="showLabel ? label : undefined"
            :icon="icon"
            severity="secondary"
            @click="onToggle"
        />

        <PrimeMenu ref="menu" id="overlay_menu" :model="items" :popup="true" />
    </div>
</template>
