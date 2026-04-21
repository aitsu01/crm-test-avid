<script setup lang="ts">
import AppearanceTabs from '@/avid/components/AppearanceTabs.vue';
import HeadingSmall from '@/avid/components/layout/HeadingSmall.vue';

import MainLayout from '@/layouts/avid/MainLayout.vue';
import ProfileLayout from '@/avid/layouts/profile/Layout.vue';
</script>

<template>
    <MainLayout>
        <ProfileLayout>
            <PrimeCard>
                <template #header>
                    <div class="border-b px-5 py-3">
                        <HeadingSmall :title="$t('avid::settings.appearance')"
                            :description="$t('avid::settings.update_your_account_appearance_settings')" />
                    </div>
                </template>

                <template #content>
                    <AppearanceTabs />
                </template>
            </PrimeCard>
        </ProfileLayout>
    </MainLayout>
</template>
