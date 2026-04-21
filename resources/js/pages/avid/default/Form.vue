<script setup lang="ts">
import { FormBuilder } from '@/avid/components/form';
import MainLayout from '@/layouts/avid/MainLayout.vue';
import { Form } from '@/avid/types/form';

defineProps<{
    form: Form;
}>();
</script>

<template>
    <MainLayout>
        <FormBuilder :form="form" />
    </MainLayout>
</template>
