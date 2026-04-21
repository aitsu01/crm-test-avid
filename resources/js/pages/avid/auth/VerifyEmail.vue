<script setup lang="ts">
import TextLink from '@/avid/components/TextLink.vue';
import AuthLayout from '@/layouts/avid/AuthLayout.vue';

defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(avidRoute('verification.send'));
};
</script>

<template>
    <AuthLayout
        :title="$t('avid::auth.verify_email')"
        :description="$t('avid::auth.verify_your_email_by_clicking_on_the_link_we_just_sent_you_by_email')"
    >
        <Head :title="$t('avid::auth.verify_email')" />

        <div v-if="status === 'verification-link-sent'" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ $t('avid::auth.a_new_verification_link_has_been_sent_to_the_email_address_you_provided_during_registration') }}
        </div>

        <PrimeCard>
            <template #content>
                <form @submit.prevent="submit" class="space-y-6 text-center">
                    <PrimeButton
                        type="submit"
                        :label="$t('avid::auth.resend_verification_email')"
                        :loading="form.processing"
                        :disabled="form.processing"
                    />

                    <TextLink :href="avidRoute('logout')" method="post" as="button" class="mx-auto block text-sm">
                        {{ $t('avid::auth.logout') }}
                    </TextLink>
                </form>
            </template>
        </PrimeCard>
    </AuthLayout>
</template>
