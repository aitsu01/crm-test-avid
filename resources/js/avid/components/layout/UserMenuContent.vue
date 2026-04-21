<script setup lang="ts">
import UserInfo from '@/avid/components/layout/UserInfo.vue';
import { useAppearance } from '@/avid/composables/useAppearance';
import { DropdownMenuGroup, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator } from '@/components/ui/dropdown-menu';
import type { User } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { LogOut, Monitor, Moon, Settings, Sun } from 'lucide-vue-next';

interface Props {
    user: User;
}

const { appearance, updateAppearance } = useAppearance();

const tabs = [
    { value: 'light', Icon: Sun, label: 'Chiaro' },
    { value: 'dark', Icon: Moon, label: 'Scuro' },
    { value: 'system', Icon: Monitor, label: 'Sistema' },
] as const;

const handleLogout = () => {
    router.flushAll();
};

defineProps<Props>();
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <UserInfo :user="user" :show-email="true" />
        </div>
    </DropdownMenuLabel>

    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <div class="flex gap-1 rounded-lg bg-neutral-100 p-1 dark:bg-neutral-800">
            <button
                v-for="{ value, Icon, label } in tabs"
                :key="value"
                @click="updateAppearance(value)"
                :class="[
                    'text-ce flex flex-1 items-center rounded-md px-3.5 py-1.5 transition-colors',
                    appearance === value
                        ? 'bg-white shadow-xs dark:bg-neutral-700 dark:text-neutral-100'
                        : 'text-neutral-500 hover:bg-neutral-200/60 hover:text-black dark:text-neutral-400 dark:hover:bg-neutral-700/60',
                ]"
            >
                <component v-tooltip="label" :is="Icon" class="mx-auto h-4 w-4" />
                <!-- <span class="ml-1.5 text-sm">{{ label }}</span> -->
            </button>
        </div>
    </DropdownMenuGroup>

    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full" :href="avidRoute('profile.edit')" prefetch as="button">
                <Settings class="mr-2 h-4 w-4" />
                {{ $t('avid::settings.settings') }}
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="post" :href="avidRoute('logout')" @click="handleLogout" as="button">
            <LogOut class="mr-2 h-4 w-4" />
            {{ $t('avid::settings.logout') }}
        </Link>
    </DropdownMenuItem>
</template>
