<script setup lang="ts">
import { HeadlessModal } from '@inertiaui/modal-vue'
import DialogRoot from './modal/DialogRoot.vue';

const modal = ref(null)

defineEmits(['after-leave', 'blur', 'close', 'focus', 'success'])

defineExpose({
    afterLeave: () => modal.value?.afterLeave(),
    close: () => modal.value?.close(),
    emit: (...args: any) => modal.value?.emit(...args),
    getChildModal: () => modal.value?.getChildModal(),
    getParentModal: () => modal.value?.getParentModal(),
    reload: (...args: any) => modal.value?.reload(...args),
    setOpen: (...args: any) => modal.value?.setOpen(...args),

    get config() {
        return modal.value?.config
    },
    get id() {
        return modal.value?.id
    },
    get index() {
        return modal.value?.index
    },
    get isOpen() {
        return modal.value?.isOpen
    },
    get modalContext() {
        return modal.value?.modalContext
    },
    get onTopOfStack() {
        return modal.value?.onTopOfStack
    },
    get shouldRender() {
        return modal.value?.shouldRender
    },
})

</script>

<template>
    <HeadlessModal
        ref="modal"
        v-slot="{
            afterLeave,
            close,
            config,
            emit,
            getChildModal,
            getParentModal,
            id,
            index,
            modalContext,
            onTopOfStack,
            isOpen,
            reload,
            setOpen,
        }"
        @success="$emit('success')"
        @close="$emit('close')"
        @focus="$emit('focus')"
        @blur="$emit('blur')"
    >
        <DialogRoot
            :is-open="isOpen"
            :config="config"
            :update:is-open="setOpen"
        >
            <slot
                :afterLeave="afterLeave"
                :close="close"
                :config="config"
                :emit="emit"
                :getChildModal="getChildModal"
                :getParentModal="getParentModal"
                :id="id"
                :index="index"
                :modalContext="modalContext"
                :onTopOfStack="onTopOfStack"
                :reload="reload"
            ></slot>
        </DialogRoot>
    </HeadlessModal>
</template>
