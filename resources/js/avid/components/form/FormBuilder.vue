<script setup lang="ts">
import { Form as FormType } from '@/avid/types/form';
import { cloneDeep } from 'lodash';
import FormElement from './FormElement.vue';

const props = defineProps<{
    form: FormType;
    close?: () => void;
}>();

const emit = defineEmits<{
    (e: 'success'): void;
    (e: 'error'): void;
    (e: 'finish'): void;
}>();

const inertiaForm = useForm({
    _method: props.form.method,
    ...cloneDeep(props.form.defaultData),
});

const finalSubmitLabel = computed(() => {
    return props.form.method === 'post' ? 'avid::form.create' : 'avid::form.save';
});

const onSubmit = () => {
    if (!props.form.submit) {
        return;
    }

    inertiaForm.post(props.form.submit, {
        preserveScroll: true,
        onSuccess: () => {
            emit('success')

            if (props.close) {
                props.close();
            }
        },
        onError: () => emit('error'),
        onFinish: () => emit('finish'),
    });
};
</script>

<template>
    <form class="space-y-5" @submit.prevent="onSubmit">
        <!-- v-focustrap  -->
        <template v-for="input in form.schema" :key="input.props.name">
            <FormElement v-model:inertia-form="inertiaForm" :schema="input" />
        </template>

        <div
            v-if="form.buttonsPosition !== 'hidden'"
            class="flex gap-4"
            :class="{
                'justify-start': form.buttonsPosition === 'start',
                'justify-center': form.buttonsPosition === 'center',
                'justify-end': form.buttonsPosition === 'end',
            }"
        >
            <PrimeButton :label="$t(finalSubmitLabel)" type="submit" :loading="inertiaForm.processing" />

            <PrimeButton v-if="close" :label="$t('avid::form.cancel')" severity="secondary" @click="close" />

            <Link v-else-if="form.cancel" :href="form.cancel">
                <PrimeButton :label="$t('avid::form.cancel')" severity="secondary" />
            </Link>
        </div>
    </form>
</template>
