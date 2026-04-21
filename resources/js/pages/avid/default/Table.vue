<script setup lang="ts">
import { DataTable } from '@/avid/components/table';
import MainLayout from '@/layouts/avid/MainLayout.vue';
import { Table } from '@/avid/types/table';

defineProps<{
    table: Table;
}>();
</script>

<template>
    <MainLayout>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <DataTable :table="table" />
        </div>
    </MainLayout>
</template>
