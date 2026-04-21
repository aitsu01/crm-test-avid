<script setup lang="ts">
import { FieldPassword } from '@/avid/components/form';
import AuthLayout from '@/layouts/avid/AuthLayout.vue';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(avidRoute('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <AuthLayout
        :title="$t('avid::auth.confirm_your_password')"
        :description="$t('avid::auth.this_is_a_protected_area_of_the_application_confirm_your_password_before_continuing')"
    >
        <Head :title="$t('avid::auth.confirm_your_password')" />

        <PrimeCard>
            <template #content>
                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        <FieldPassword
                            v-model="form.password"
                            :label="$t('avid::auth.password')"
                            name="password"
                            required
                            :error="form.errors.password"
                        />

                        <PrimeButton
                            type="submit"
                            :label="$t('avid::auth.confirm_password')"
                            :loading="form.processing"
                            :disabled="form.processing"
                        />
                    </div>
                </form>
            </template>
        </PrimeCard>
    </AuthLayout>
</template>
