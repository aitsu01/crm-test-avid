<script setup lang="ts" generic="T extends Record<string, FormDataConvertible>">
import { FormDataType, type ActiveVisit, type Errors, type FormDataConvertible, type Page, type PageProps } from '@inertiajs/core';
import type { InertiaForm } from '@inertiajs/vue3';
import { cloneDeep } from 'lodash';

const props = withDefaults(
    defineProps<{
        defaultData: T;
        method?: 'post' | 'put';
        action?: string;
        cancel?: string | (() => void) | null;
        preserveScroll?: boolean;
        errorBag?: string | null | undefined;
        submitLabel?: string | null;
        resetOnSuccess?: boolean;
        resetOnError?: boolean;
        resetOnFinish?: boolean;
        transform?: (data: T) => object;
        success?: (e?: Page<PageProps>, form?: InertiaForm<T>) => void;
        error?: (e?: Errors, form?: InertiaForm<T>) => void;
        finish?: (e?: ActiveVisit, form?: InertiaForm<T>) => void;
    }>(),
    {
        method: 'post',
        cancel: null,
        preserveScroll: false,
        errorBag: undefined,
        submitLabel: null,
        resetOnSuccess: false,
        resetOnError: false,
        resetOnFinish: false,
        transform: (data: T) => data,
        success: () => {},
        error: () => {},
        finish: () => {},
    },
);

const form = useForm<FormDataType<T>>(cloneDeep(props.defaultData));

const cancelCallback = computed(() => {
    if (typeof props.cancel !== 'function') {
        return null;
    }
    return props.cancel;
});

const cancelLink = computed(() => {
    if (typeof props.cancel !== 'string') {
        return null;
    }
    return props.cancel;
});

const finalSubmitLabel = computed(() => {
    if (props.submitLabel) {
        return props.submitLabel;
    }

    return props.method === 'post' ? 'Crea' : 'Salva';
});

const onSubmit = () => {
    if (!props.action) {
        return;
    }

    form.transform(props.transform).submit(props.method, props.action, {
        preserveScroll: props.preserveScroll,
        errorBag: props.errorBag,
        // forceFormData: true,

        onSuccess: (e: Page<PageProps>) => {
            if (props.resetOnSuccess) {
                form.reset();
            }

            props.success(e, form);
        },
        onError: (e: Errors) => {
            if (props.resetOnError) {
                form.reset();
            }

            props.error(e, form);
        },
        onFinish: (e: ActiveVisit) => {
            if (props.resetOnFinish) {
                form.reset();
            }

            props.finish(e, form);
        },
    });
};
</script>

<template>
    <form v-focustrap  @submit.prevent="onSubmit">
        <div class="space-y-5 mb-5">
            <slot :data="form"></slot>
        </div>

        <div class="flex gap-4">
            <PrimeButton :label="finalSubmitLabel" type="submit" :loading="form.processing" />

            <Link v-if="cancelLink" :href="cancelLink">
                <PrimeButton label="Annulla" severity="secondary" />
            </Link>

            <PrimeButton v-else-if="cancelCallback" label="Annulla" severity="secondary" @click="cancelCallback" />
        </div>
    </form>
</template>
