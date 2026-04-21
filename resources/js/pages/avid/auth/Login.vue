<script setup lang="ts">
import { FieldCheckbox, FieldText } from '@/avid/components/form';
import TextLink from '@/avid/components/TextLink.vue';
import AuthBase from '@/avid/layouts/AuthLayout.vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(avidRoute('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase :title="$t('avid::auth.log_in_to_your_account')" :description="$t('avid::auth.enter_your_email_and_password_below_to_log_in')">
        <Head :title="$t('avid::auth.login')" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <PrimeCard>
            <template #content>
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <FieldText
                            v-model="form.email"
                            :label="$t('avid::auth.email')"
                            name="email"
                            type="email"
                            required
                            :error="form.errors.email"
                        />

                        <div class="flex w-full flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <label>{{ $t('avid::auth.password') }} <span class="text-red-600">*</span></label>

                                <TextLink v-if="canResetPassword" :href="avidRoute('password.request')" class="text-sm" :tabindex="5">
                                    {{ $t('avid::auth.forgot_password') }}
                                </TextLink>
                            </div>

                            <PrimePassword
                                id="password"
                                v-model="form.password"
                                name="password"
                                fluid
                                :invalid="!!form.errors.password"
                                :feedback="false"
                                :toggle-mask="true"
                            />

                            <PrimeMessage v-if="form.errors.password" severity="error" size="small" variant="simple">
                                {{ form.errors.password }}
                            </PrimeMessage>
                        </div>

                        <FieldCheckbox v-model="form.remember" name="remember" :placeholder="$t('avid::auth.remember_me')" />

                        <PrimeButton type="submit" fluid :loading="form.processing" :disabled="form.processing">
                            {{ $t('avid::auth.login') }}
                        </PrimeButton>
                    </div>
                </form>
            </template>
        </PrimeCard>
    </AuthBase>
</template>
