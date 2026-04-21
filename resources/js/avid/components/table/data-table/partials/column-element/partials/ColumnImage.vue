<script setup lang="ts">
const props = defineProps<{
    state: any;
    width?: string;
    height?: string;
    isCircular?: boolean;
    isSquare?: boolean;
}>();

const finalHeight = computed(() => {
    if (props.isCircular || props.isSquare) {
        return props.width;
    }

    return props.height;
});
</script>

<template>
    <div @click.stop.prevent>
        <PrimeImage
            v-if="state"
            :src="state"
            preview
            :image-class="[
                '!object-cover w-full h-full',
                {
                    'aspect-square': isCircular || isSquare,
                    'rounded-full': isCircular,
                },
            ]"
            :class="{
                'rounded-full': isCircular,
            }"
            :style="{
                width,
                height: finalHeight,
            }"
            :pt="{
                previewMask: isCircular ? 'rounded-full' : '',
            }"
        />
    </div>
</template>
