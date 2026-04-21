<script setup lang="ts">

const props = defineProps<{
    config: {
        name: string
        slideover: boolean
        closeButton: boolean
        closeExplicitly: boolean
        maxWidth: string
        paddingClasses: boolean | string
        panelClasses: boolean | string
        position: string
    }
}>()

const isOpen = defineModel<boolean>('isOpen');

const size = computed(() => {
    switch (props.config.maxWidth) {
        case 'sm':
            return 'w-sm';
        case 'md':
            return 'w-md';
        case 'lg':
            return 'w-lg';
        case 'xl':
            return 'w-xl';
        case '2xl':
            return 'w-2xl';
        case '3xl':
            return 'w-3xl';
        case '4xl':
            return 'w-4xl';
        case '5xl':
            return 'w-5xl';
        case '6xl':
            return 'w-6xl';
    }
})
</script>

<template>
    <PrimeDialog
        v-model:visible="isOpen"
        modal
        header=""
        :position="config.position"
        :pt="{
            root: size,
            header: 'justify-end pt-2 pb-0 px-2',
            content: config.paddingClasses + ' !pt-1',
        }"
        :draggable="false"
        :dismissableMask="! config.closeExplicitly"
        :closable="config.closeButton"
    >
        <slot></slot>
    </PrimeDialog>
</template>
