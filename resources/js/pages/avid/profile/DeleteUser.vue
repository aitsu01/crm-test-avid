<script setup lang="ts">
import { FieldPassword } from '@/avid/components/form';
import HeadingSmall from '@/avid/components/layout/HeadingSmall.vue';
import MainLayout from '@/layouts/avid/MainLayout.vue';
import ProfileLayout from '@/avid/layouts/profile/Layout.vue';

const form = useForm({
    password: '',
});

const isOpen = ref(false);

const deleteUser = (e: Event) => {
    e.preventDefault();

    form.delete(avidRoute('delete_user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    form.clearErrors();
    form.reset();
    isOpen.value = false;
};
</script>

<template>
    <MainLayout>
        <ProfileLayout>
            <PrimeCard>
                <template #header>
                    <div class="border-b px-5 py-3">
                        <HeadingSmall :title="$t('avid::settings.delete_account')"
                            :description="$t('avid::settings.delete_your_account_and_all_its_data')" />
                    </div>
                </template>

                <template #content>
                    <div
                        class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
                        <div class="relative space-y-0.5 text-red-600 dark:text-red-100">
                            <p class="text-lg font-medium">{{ $t('avid::settings.warning') }}</p>
                            <p class="text-base">{{
                                $t('avid::settings.please_proceed_with_caution_this_operation_cannot_be_undone') }}</p>
                        </div>

                        <PrimeButton severity="danger" :label="$t('avid::settings.delete_account')"
                            @click="isOpen = true" />

                        <PrimeDialog v-model:visible="isOpen" :closable="false" modal
                            :header="$t('avid::settings.are_you_sure_you_want_to_delete_your_account')"
                            :style="{ width: '35rem' }">
                            <form class="space-y-4" @submit="deleteUser">
                                <p>
                                    {{
                                        $t(
                                            'avid::settings.once_you_delete_your_account_all_of_its_data_will_be_permanently_deleted_enter_your_password_to_confirm_that_you_want_to_permanently_delete_your_account',
                                        )
                                    }}
                                </p>

                                <FieldPassword v-model="form.password" :label="$t('avid::form.password')"
                                    name="password" required :error="form.errors.password" />

                                <div class="flex justify-end gap-2">
                                    <PrimeButton type="button" :label="$t('avid::form.cancel')" severity="secondary"
                                        @click="closeModal" />
                                    <PrimeButton type="submit" :label="$t('avid::settings.delete_account')"
                                        severity="danger" />
                                </div>
                            </form>
                        </PrimeDialog>
                    </div>
                </template>
            </PrimeCard>
        </ProfileLayout>
    </MainLayout>
</template>
