<script setup lang="ts">
import { FieldPassword, FieldText } from '@/avid/components/form';
import AuthLayout from '@/layouts/avid/AuthLayout.vue';

interface Props {
    token: string;
    email: string;
}

const props = defineProps<Props>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(avidRoute('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <AuthLayout :title="$t('avid::auth.reset_password')" :description="$t('avid::auth.enter_your_new_password')">
        <Head :title="$t('avid::auth.reset_password')" />

        <PrimeCard>
            <template #content>
                <form @submit.prevent="submit">
                    <div class="grid gap-6">
                        <FieldText
                            v-model="form.email"
                            :label="$t('avid::auth.email')"
                            name="email"
                            type="email"
                            required
                            :error="form.errors.email"
                        />

                        <FieldPassword
                            v-model="form.password"
                            :label="$t('avid::auth.password')"
                            name="password"
                            required
                            :error="form.errors.password"
                        />

                        <FieldPassword
                            v-model="form.password_confirmation"
                            :label="$t('avid::auth.confirm_password')"
                            name="password_confirmation"
                            required
                            :error="form.errors.password_confirmation"
                        />

                        <PrimeButton type="submit" :label="$t('avid::auth.reset_password')" :loading="form.processing" :disabled="form.processing" />
                    </div>
                </form>
            </template>
        </PrimeCard>
    </AuthLayout>
</template>
