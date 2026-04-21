<script setup lang="ts">
import { useColor } from '@/avid/composables/useColor';
import { useAsyncWidget } from './composables/use-async-widget';
import { Schema } from '@/avid/types/widget';
import { useDebounceFn } from '@vueuse/core';
import WidgetCard from './partials/WidgetCard.vue';

interface WidgetStat {
    heading?: string;
    value?: any;
    icon?: string;
    iconPosition?: 'before' | 'after';
    iconColor?: string;
    description?: string;
    descriptionIcon?: string;
    descriptionIconPosition?: 'before' | 'after';
    descriptionColor?: string;
    color?: string;
    chart?: number[];
    chartColor?: string;
}

const props = defineProps<{
    schema: Schema
}>()

const { toRgba } = useColor();
const { loading, fetchData } = useAsyncWidget();

const widget = ref<WidgetStat>({
    ...props.schema.props,
});

const iconColor = computed(() => widget.value.iconColor ?? widget.value.color);
const descriptionColor = computed(() => widget.value.descriptionColor ?? widget.value.color);
const chartColor = computed(() => widget.value.chartColor ?? widget.value.color ?? '#3b82f6');


const data = computed(() => {
    if (! widget.value.chart) {
        return {};
    }

    return {
        labels: widget.value.chart,
        datasets: [
            {
                label: widget.value.heading,
                data: widget.value.chart,
                borderColor: chartColor.value,
                backgroundColor: toRgba(chartColor.value, 0.1),
                fill: true,                  // riempimento area
                tension: 0.4,                // curva morbida (0 = linee dritte)
                borderWidth: 2,              // spessore linea
                pointRadius: 0,              // rimuove i punti
            }
        ]
    }
})

const options = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false // 🔹 nasconde la legenda
        },
        tooltip: {
            enabled: false // (opzionale) disabilita tooltip
        }
    },
    scales: {
        x: {
            display: false, // 🔹 nasconde asse X
            grid: {
                display: false // 🔹 rimuove griglia X
            }
        },
        y: {
            display: false, // 🔹 nasconde asse Y
            grid: {
                display: false // 🔹 rimuove griglia Y
            }
        }
    }
}

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
        <div class="space-y-2">
            <div class="flex items-center gap-5">
                <div v-if="widget.icon" class="flex-shrink-0" :class="{
                    'order-1': widget.iconPosition === 'after',
                }">
                    <i class="text-3xl md:text-4xl" :class="widget.icon" :style="{
                        color: iconColor,
                    }"></i>
                </div>
    
                <div class="flex-1">
                    <div class="text-gray-500 font-medium dark:text-gray-300">
                        {{ widget.heading }}
                    </div>
                    <div class="font-semibold text-3xl md:text-4xl">
                        {{ widget.value }}
                    </div>
                </div>
            </div>
    
            <div v-if="widget.description" class="flex items-center gap-2" :style="{
                color: descriptionColor,
            }">
                <div v-if="widget.descriptionIcon" :class="{
                    'order-1': widget.descriptionIconPosition === 'after',
                }" class="flex items-center">
                    <i class="text-xl" :class="widget.descriptionIcon"></i>
                </div>
    
                <div>
                    {{ widget.description }}
                </div>
            </div>
        </div>
    
        <div v-if="widget.chart" class="absolute left-0 -right-1 bottom-0 z-0">
            <PrimeChart  type="line" :data="data" :options="options" :height="24" />
        </div>
    </WidgetCard>
</template>
