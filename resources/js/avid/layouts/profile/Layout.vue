<script setup lang="ts">
import Heading from '@/avid/components/layout/Heading.vue';
import { Avid, type NavItem } from '@/avid/types';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { Link, usePage } from '@inertiajs/vue3';

const settings = computed(() => (usePage().props.avid as Avid).settings);

const sidebarNavItems = computed<NavItem[]>(() => {
    const items = [];

    if (settings.value.canUpdateProfile) {
        items.push({
            title: 'avid::settings.profile',
            href: avidRoute('profile.edit'),
        });
    }

    if (settings.value.canUpdatePassword) {
        items.push({
            title: 'avid::settings.password',
            href: avidRoute('password.edit'),
        });
    }

    items.push({
        title: 'avid::settings.appearance',
        href: avidRoute('appearance'),
    });

    if (settings.value.canDeleteAccount) {
        items.push({
            title: 'avid::settings.delete_account',
            href: avidRoute('delete_user.show'),
        });
    }

    return items;
});

const currentPath = route(route().current());
</script>

<template>
    <div class="px-4 py-6">
        <Heading :title="$t('avid::settings.settings')" :description="$t('avid::settings.manage_your_profile_settings')" />

        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1.5 space-x-0">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="item.href"
                        variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': currentPath === item.href }]"
                        as-child
                    >
                        <Link :href="item.href">
                            {{ $t(item.title) }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 lg:hidden" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-8">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
