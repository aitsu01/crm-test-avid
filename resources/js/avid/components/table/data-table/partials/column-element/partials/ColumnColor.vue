<script setup lang="ts">
defineProps<{
    state: any;
}>();
</script>

<template>
    <div>
        <div
            class="h-7 w-7 rounded-lg"
            :style="{
                backgroundColor: state,
            }"
        ></div>
    </div>
</template>
