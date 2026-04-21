<script setup lang="ts">
import DialogContent from './partials/DialogContent.vue';
import SlideoverContent from './partials/SlideoverContent.vue';

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

const modalComponent = computed(() => props.config.slideover ? SlideoverContent : DialogContent);
</script>

<template>
    <component
        v-model:is-open="isOpen"
        :is="modalComponent"
        :config="config"
    >
        <slot></slot>
    </component>
</template>
