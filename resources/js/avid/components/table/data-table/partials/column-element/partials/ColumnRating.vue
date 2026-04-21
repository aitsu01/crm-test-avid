<script setup lang="ts">
defineProps<{
    state: any;
}>();
</script>

<template>
    <div>
        <PrimeRating :model-value="state" readonly />
    </div>
</template>
