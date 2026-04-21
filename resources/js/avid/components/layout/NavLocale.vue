<script setup lang="ts">
import { Avid } from '@/avid/types';
import { type User } from '@/types';
import { Button } from '@/components/ui/button';
import { Languages } from 'lucide-vue-next';
import { useSidebar } from '@/components/ui/sidebar';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger, DropdownMenuSeparator, DropdownMenuGroup, DropdownMenuItem, DropdownMenuCheckboxItem } from '@/components/ui/dropdown-menu';

const page = usePage();
const user = computed(() => page.props.auth.user as User);
const { isMobile, state } = useSidebar();

const settings = computed(() => (usePage().props.avid as Avid).settings);

const onUpdateLocale = (locale: string) => {
    router.put(avidRoute('locale.update'), { locale: locale }, {
        onSuccess: () => {
            window.location.reload();
        }
    });
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost">
                <Languages class="ml-auto size-5" />
            </Button>
        </DropdownMenuTrigger>

        <DropdownMenuContent
            class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"
            :side="isMobile ? 'bottom' : state === 'collapsed' ? 'left' : 'bottom'"
            align="center"
            :side-offset="4"
        >
            <!-- <PrimeScrollPanel style="width: 100%; height: 200px"> -->
                <DropdownMenuGroup>
                    <template v-for="(locale, i) in settings.locales">

                        <DropdownMenuCheckboxItem
                            :model-value="locale.key === user.locale"
                            @update:model-value="onUpdateLocale(locale.key)"
                        >
                            {{ locale.label }}
                        </DropdownMenuCheckboxItem>

                        <DropdownMenuSeparator v-if="i < settings.locales.length - 1" />
                    </template>
                </DropdownMenuGroup>

            <!-- </PrimeScrollPanel> -->
        </DropdownMenuContent>
    </DropdownMenu>

</template>
