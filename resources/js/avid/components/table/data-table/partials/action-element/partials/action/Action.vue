<script setup lang="ts">
const props = defineProps<{
    name: string;
    label?: string;
    color?: any;
    icon?: string;
    method: 'get' | 'post' | 'put' | 'delete';
    url?: string;
    requiresConfirmation?: boolean;
    confirmationMessage?: string;
    shouldOpenUrlInNewTab?: boolean;
    shouldOpenUrlInModal?: boolean;
    showLabel?: boolean;
    disabled?: boolean;
    modalSize?: 'sm' | 'lg' | 'xl' | '2xl' | '3xl' | '4xl' | '5xl' | '6xl';
}>();

const emit = defineEmits<{
    (e: 'action', action: string): void;
}>();

const confirm = useConfirm();

const wrapperMap: any = {
    Default: defineAsyncComponent(() => import('./partials/DefaultWrapper.vue')),
    Link: defineAsyncComponent(() => import('./partials/LinkWrapper.vue')),
    ModalLink: defineAsyncComponent(() => import('./partials/ModalLinkWrapper.vue')),
    NewTab: defineAsyncComponent(() => import('./partials/NewTabWrapper.vue')),
};

const wrapper = computed(() => {
    if (props.method !== 'get' || !props.url) {
        return wrapperMap['Default'];
    }

    if (props.shouldOpenUrlInNewTab) {
        return wrapperMap['NewTab'];
    }

    if (props.shouldOpenUrlInModal) {
        return wrapperMap['ModalLink'];
    }

    return wrapperMap['Link'];
});

const severity = computed(() => {
    switch (props.color) {
        case 'warning':
            return 'warn';
        default:
            return props.color;
    }
});

const runAction = () => {
    if (!props.url) {
        return;
    }

    router.visit(props.url, {
        method: props.method,
        data: {},
        preserveScroll: true,
        preserveState: true,
    });
};

const onClick = () => {
    emit('action', props.name);

    if (props.method === 'get') {
        return;
    }

    if (props.requiresConfirmation) {
        confirm.require({
            message: props.confirmationMessage,
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
                runAction();
            },
        });
    } else {
        runAction();
    }
};
</script>

<template>
    <div>
        <component :is="wrapper" :url="url" :modal-size="modalSize">
            <PrimeButton
                v-tooltip.top="showLabel ? (label ?? undefined) : label"
                :icon="icon"
                :aria-label="label"
                :label="showLabel ? label : undefined"
                :severity="severity"
                variant="text"
                class="!px-1 !py-1"
                :disabled="disabled"
                @click="onClick"
            />
        </component>
    </div>
</template>
