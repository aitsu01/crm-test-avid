<script setup lang="ts">
import HeadingSmall from '@/avid/components/layout/HeadingSmall.vue';
import { useAsyncWidget } from './composables/use-async-widget';
import { Schema } from '@/avid/types/widget';
import { useDebounceFn } from '@vueuse/core';
import WidgetCard from './partials/WidgetCard.vue';

interface WidgetChart {
    heading?: string;
    description?: string;
    type: string;
    data: any;
    options?: any;
    height?: number;
    async?: boolean;
}

const props = defineProps<{
    schema: Schema
}>()

const { loading, fetchData } = useAsyncWidget();

const widget = ref<WidgetChart>({
    ...props.schema.props,
});

const loadData = useDebounceFn(async () => {
    if (! props.schema.async) {
        return;
    }

    loading.value = true;

    const data = await fetchData(props.schema.id, props.schema.params);

    if (! data) {
        return;
    }

    widget.value = {
        ...data.props
    }

    loading.value = false;
}, 200)

watch(() => props.schema.params, () => {
    loadData()
})

onMounted(() => {
    loadData();
})
</script>

<template>
    <WidgetCard :loading="loading" :placeholder-height="schema.placeholderHeight">
        <template v-if="widget.heading || widget.description" #header>
            <div class="border-b px-5 py-3">
                <HeadingSmall :title="widget.heading" :description="widget.description" />
            </div>
        </template>

        <PrimeChart
            :type="widget.type"
            :data="widget.data"
            :options="widget.options"
            :heigh="widget.height"
        />
    </WidgetCard>
</template>
