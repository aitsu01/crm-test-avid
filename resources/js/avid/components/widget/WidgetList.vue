<script setup lang="ts">
import HeadingSmall from '@/avid/components/layout/HeadingSmall.vue';
import WidgetCard from './partials/WidgetCard.vue';
import { Schema } from '@/avid/types/widget';
import { useAsyncWidget } from './composables/use-async-widget';
import { useDebounceFn } from '@vueuse/core';

interface Item {
    heading?: string;
    description?: string;
    descriptionIcon?: string;
    descriptionColor?: string;
    url?: string;
    image?: string;
    icon?: string;
    iconColor?: string;
    iconBackgroundColor?: string;
}

interface WidgetList {
    heading?: string;
    description?: string;
    async?: string;
    items?: Item[];
}

const props = defineProps<{
    schema: Schema
}>()

const { loading, fetchData } = useAsyncWidget();

const widget = ref<WidgetList>({
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
            <div class="border-b px-5 py-3 ">
                <HeadingSmall :title="widget.heading" :description="widget.description" />
            </div>
        </template>


        <div class="space-y-6">
            <template v-for="(item, i) in widget.items" :key="i">
                <div class="flex items-center gap-4">
                    <template v-if="item.url">
                        <a v-if="item.url" :href="item.url" target="_blank" class="block" >
                            <div v-if="item.image || item.icon"
                                class="w-11 h-11 rounded-full overflow-hidden flex items-center justify-center"
                                :style="{
                                    color: item.iconColor ?? '#fff',
                                    backgroundColor: item.iconBackgroundColor ?? '#3b82f6',
                                }"
                            >
                                <img v-if="item.image" :src="item.image" alt="" class="w-full h-full object-cover">
    
                                <i :class="item.icon"></i>
                            </div>
                        </a>
                    </template>
                    <template v-else>
                        <div v-if="item.image || item.icon"
                            class="w-11 h-11 rounded-full overflow-hidden flex items-center justify-center"
                            :style="{
                                color: item.iconColor ?? '#fff',
                                backgroundColor: item.iconBackgroundColor ?? '#3b82f6',
                            }"
                        >
                            <img v-if="item.image" :src="item.image" alt="" class="w-full h-full object-cover">
    
                            <i :class="item.icon"></i>
                        </div>
                    </template>
    
                    <div class="space-y-1">
                        <template v-if="item.heading">
                            <a v-if="item.url" :href="item.url" target="_blank" class="font-semibold block hover:text-primary-500">
                                {{ item.heading }}
                            </a>
                            <p v-else class="font-semibold">{{ item.heading }}</p>
                        </template>
    
                        <p v-if="item.description" class="text-sm flex items-center gap-2" :style="{
                            color: item.descriptionColor ?? '#64748b'
                        }">
                            <i v-if="item.descriptionIcon" class="text-sm" :class="item.descriptionIcon"></i>
    
                            <span>
                                {{ item.description }}
                            </span>
                        </p>
                    </div>
                </div>
            </template>
        </div>
    </WidgetCard>
</template>
