<script setup lang="ts">
import { FieldPassword } from '@/avid/components/form';
import HeadingSmall from '@/avid/components/layout/HeadingSmall.vue';
import MainLayout from '@/layouts/avid/MainLayout.vue';
import ProfileLayout from '@/avid/layouts/profile/Layout.vue';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(avidRoute('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <MainLayout>
        <ProfileLayout>
            <PrimeCard>
                <template #header>
                    <div class="border-b px-5 py-3">
                        <HeadingSmall :title="$t('avid::settings.change_password')"
                            :description="$t('avid::settings.make_sure_your_account_uses_a_long_random_password_to_stay_secure')" />
                    </div>
                </template>

                <template #content>
                    <form @submit.prevent="updatePassword" class="space-y-5">
                        <FieldPassword v-model="form.current_password" :label="$t('avid::form.current_password')"
                            name="current_password" required :error="form.errors.current_password" />

                        <FieldPassword v-model="form.password" :label="$t('avid::form.new_password')" name="password"
                            required :error="form.errors.password" />

                        <FieldPassword v-model="form.password_confirmation" :label="$t('avid::form.confirm_password')"
                            name="password_confirmation" required :error="form.errors.password_confirmation" />

                        <PrimeButton type="submit" :label="$t('avid::settings.save_password')"
                            :loading="form.processing" :disabled="form.processing" />
                    </form>
                </template>
            </PrimeCard>
        </ProfileLayout>
    </MainLayout>
</template>
