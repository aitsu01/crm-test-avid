<script setup lang="ts">
import { useAppearance } from '@/avid/composables/useAppearance';
import { Avid } from '@/avid/types';

const props = withDefaults(
    defineProps<{
        position?: 'sidebar' | 'auth';
    }>(),
    {
        position: 'sidebar',
    },
);

const { appearance } = useAppearance();

const logo = computed(() => {
    const logo: any = (usePage().props.avid as Avid).settings.logo;
    if (appearance.value === 'dark') {
        return logo.dark[props.position];
    }

    return logo.light[props.position];
});
</script>

<template>
    <img :src="logo" class="w-full" />
</template>
