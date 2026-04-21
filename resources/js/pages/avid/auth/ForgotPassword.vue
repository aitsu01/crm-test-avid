<script setup lang="ts">
import { FieldText } from '@/avid/components/form';
import TextLink from '@/avid/components/TextLink.vue';
import AuthLayout from '@/layouts/avid/AuthLayout.vue';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(avidRoute('password.email'));
};
</script>

<template>
    <AuthLayout
        :title="$t('avid::auth.forgot_password')"
        :description="$t('avid::auth.enter_your_email_address_to_receive_a_link_to_reset_your_password')"
    >
        <Head :title="$t('avid::auth.forgot_password')" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <div class="space-y-6">
            <PrimeCard>
                <template #content>
                    <form @submit.prevent="submit">
                        <FieldText
                            v-model="form.email"
                            :label="$t('avid::auth.email')"
                            name="email"
                            type="email"
                            required
                            :error="form.errors.email"
                        />

                        <div class="mt-6 flex items-center justify-start">
                            <PrimeButton type="submit" fluid :loading="form.processing" :disabled="form.processing">
                                {{ $t('avid::auth.send_password_reset_link') }}
                            </PrimeButton>
                        </div>
                    </form>
                </template>
            </PrimeCard>

            <div class="space-x-1 text-center text-sm text-muted-foreground">
                <TextLink :href="avidRoute('login')">
                    {{ $t('avid::auth.or_return_to_login') }}
                </TextLink>
            </div>
        </div>
    </AuthLayout>
</template>
