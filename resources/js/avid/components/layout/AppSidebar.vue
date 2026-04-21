<script setup lang="ts">
import NavMain from '@/avid/components/layout/NavMain.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuItem } from '@/components/ui/sidebar';
import { Link } from '@inertiajs/vue3';
import AppLogo from './AppLogo.vue';
import { Avid } from '@/avid/types';

const isSettingsPage = computed(() => !!(usePage().props.avid as Avid).settingsSidebar);

</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <template v-if="isSettingsPage">
                        <Link :href="avidRoute('dashboard')" class="block border-b mb-3 ">
                            <div class="mx-auto w-[70%] pt-2 pb-4 text-xl flex items-center gap-5 text-primary-300">
                                <i class="pi pi-sign-out transform rotate-180"></i>

                                <span>
                                    {{ $t('avid::settings.back') }}
                                </span>
                            </div>
                        </Link>
                    </template>

                    <template v-else>
                        <template v-if="$slots.logo">
                            <slot name="logo"></slot>
                        </template>

                        <template v-else>
                            <Link :href="avidRoute('dashboard')">
                                <div class="mx-auto w-[70%] py-2 mb-3">
                                    <AppLogo />
                                </div>
                            </Link>
                        </template>
                    </template>
                </SidebarMenuItem>
            </SidebarMenu>

            <template v-if="$slots.sidebarHeader">
                <slot name="sidebarHeader"></slot>
            </template>
        </SidebarHeader>

        <SidebarContent>
            <NavMain />
        </SidebarContent>

        <SidebarFooter>
            <template v-if="$slots.sidebarFooter">
                <slot name="sidebarFooter"></slot>
            </template>
            <!-- <NavUser /> -->
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
