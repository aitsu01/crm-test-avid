<script setup lang="ts">
import { Avid } from '@/avid/types';
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuSub, SidebarMenuButton, SidebarMenuItem, SidebarMenuSubItem, SidebarMenuSubButton } from '@/components/ui/sidebar';
import { Link, usePage } from '@inertiajs/vue3';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible'
import { ChevronRight } from "lucide-vue-next"

const sidebar = computed(() => (usePage().props.avid as Avid).settingsSidebar ?? (usePage().props.avid as Avid).sidebar);
</script>

<template>
    <SidebarGroup v-for="group in sidebar" :key="group.id" class="px-2 py-0">
        <SidebarGroupLabel v-if="!group.hidden">{{ group.title }}</SidebarGroupLabel>
        <SidebarMenu>
            <template v-for="item in group.children" :key="item.title">
                <template v-if="item.children?.length">
                    <Collapsible as-child :default-open="item.active" class="group/collapsible">
                        <SidebarMenuItem>
                            <CollapsibleTrigger as-child>
                                <SidebarMenuButton :tooltip="item.title">
                                    <span class="flex items-center gap-2">
                                        <i class="w-6 text-lg" :class="item.icon"></i>
                                        <span>{{ item.title }}</span>
                                    </span>
                                    <ChevronRight
                                        class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                                </SidebarMenuButton>
                            </CollapsibleTrigger>

                            <CollapsibleContent>
                                <SidebarMenuSub>
                                    <template v-for="subitem in item.children" :key="subitem.title">
                                        <SidebarMenuSubItem>
                                            <SidebarMenuSubButton as-child :is-active="subitem.active"
                                                :tooltip="subitem.title">
                                                <Link v-if="subitem.link" :href="subitem.link">
                                                    <span>{{ subitem.title }}</span>
                                                </Link>
                                                <span v-else class="flex items-center gap-2">
                                                    <span>{{ subitem.title }}</span>
                                                </span>
                                            </SidebarMenuSubButton>
                                        </SidebarMenuSubItem>
                                    </template>
                                </SidebarMenuSub>
                            </CollapsibleContent>
                        </SidebarMenuItem>
                    </Collapsible>
                </template>

                <template v-else>
                    <SidebarMenuItem>
                        <SidebarMenuButton as-child :is-active="item.active" :tooltip="item.title">
                            <Link v-if="item.link" :href="item.link">
                                <i class="w-6 items-center text-lg" :class="item.icon"></i>
                                <span>{{ item.title }}</span>
                            </Link>
                            <span v-else class="flex gap-2">
                                <i class="w-6 items-center text-lg" :class="item.icon"></i>
                                <span>{{ item.title }}</span>
                            </span>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </template>
            </template>

        </SidebarMenu>
    </SidebarGroup>
</template>
