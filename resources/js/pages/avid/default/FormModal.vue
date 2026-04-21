<script setup lang="ts">
import { FormBuilder } from '@/avid/components/form';
import { Form } from '@/avid/types/form';
import ModalLayout from '@/avid/layouts/ModalLayout.vue';

defineProps<{
    form: Form;
}>();

</script>

<template>
    <ModalLayout v-slot="{ close }">
        <FormBuilder :form="form" :close="close" />
    </ModalLayout>
</template>
