<script setup lang="ts">
import AppLogo from '@/avid/components/layout/AppLogo.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-background p-6 md:p-10">
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <div class="flex flex-col items-center gap-2 font-medium">
                        <template v-if="$slots.logo">
                            <slot name="logo"></slot>
                        </template>

                        <div v-else class="mb-3 flex w-44 items-center justify-center">
                            <AppLogo position="auth" />
                        </div>

                        <span v-if="title" class="sr-only">{{ title }}</span>
                    </div>
                    <div class="space-y-2 text-center">
                        <h1 v-if="title" class="text-xl font-medium">{{ title }}</h1>
                        <p v-if="description" class="text-center text-sm text-muted-foreground">{{ description }}</p>
                    </div>
                </div>
                
                <slot />
            </div>
        </div>
    </div>
</template>
