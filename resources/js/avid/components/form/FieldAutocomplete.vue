<script setup lang="ts">
import { Field, HasAsync, HasFooter, HasHeader, HasMultiple, HasOptions, HasPlaceholder, HasSize, HasVirtualScroll } from '@/avid/types/form';
import axios from 'axios';
import { AutoCompleteCompleteEvent } from 'primevue/autocomplete';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder, HasOptions, HasHeader, HasFooter, HasMultiple, HasVirtualScroll, HasAsync {
    forceSelection?: boolean;
    dropdown?: boolean;
}

const props = withDefaults(defineProps<Props>(), {});

const model = defineModel<string | string[] | null | undefined>();

const items = ref<string[]>([]);

const virtualScollerOptions = computed(() => {
    if (!props.virtualScroll) return undefined;

    return {
        itemSize: props.virtualScroll,
    };
});

const search = (event: AutoCompleteCompleteEvent) => {
    if (props.async) {
        axios
            .get(
                route(props.async, {
                    search: event.query,
                    ...(props.params ?? {}),
                }),
            )
            .then(({ data }) => {
                items.value = data;
            });
    } else {
        if (!props.options) {
            items.value = [];
            return;
        }

        if (!event.query.trim().length) {
            items.value = [...props.options.map((option) => option.label)];
        } else {
            items.value = props.options
                .filter((option) => {
                    return option.label.toLowerCase().startsWith(event.query.toLowerCase());
                })
                .map((option) => option.label);
        }
    }
};
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeAutoComplete
                :id="name"
                v-model="model"
                :name="name"
                :size="size"
                fluid
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :suggestions="items"
                :multiple="multiple"
                :virtual-scroller-options="virtualScollerOptions"
                :dropdown="dropdown"
                @complete="search"
            >
                <template v-if="$slots.header || header" #header>
                    <template v-if="$slots.header">
                        <slot name="header"></slot>
                    </template>

                    <template v-else>
                        <template v-if="isHeaderRaw">
                            <div v-html="header"></div>
                        </template>
                        <template v-else>
                            <div class="px-3 py-2 font-medium">{{ header }}</div>
                        </template>
                    </template>
                </template>

                <template v-if="$slots.footer || footer" #footer>
                    <template v-if="$slots.footer">
                        <slot name="footer"></slot>
                    </template>

                    <template v-else>
                        <template v-if="isFooterRaw">
                            <div v-html="footer"></div>
                        </template>
                        <template v-else>
                            <div class="px-3 py-2 font-medium">{{ footer }}</div>
                        </template>
                    </template>
                </template>

                <template #empty> Nessun risultato trovato </template>
            </PrimeAutoComplete>
        </template>
    </FormControl>
</template>
