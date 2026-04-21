<script setup lang="ts">
import { DataTable } from '@/avid/components/table';
import { Table } from '@/avid/types/table';

defineProps<{
    table: Table;
}>();
</script>

<template>
    <div>
        <DataTable :table="table" />
    </div>
</template>
