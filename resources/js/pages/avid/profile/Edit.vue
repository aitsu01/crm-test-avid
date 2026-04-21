<script setup lang="ts">
import { FieldText } from '@/avid/components/form';
import HeadingSmall from '@/avid/components/layout/HeadingSmall.vue';
import MainLayout from '@/avid/layouts/MainLayout.vue';
import ProfileLayout from '@/avid/layouts/profile/Layout.vue';
import { type User } from '@/types';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const page = usePage();
const user = page.props.auth.user as User;

const form = useForm({
    name: user.name,
    email: user.email,
});

const submit = () => {
    form.patch(avidRoute('profile.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <MainLayout>
        <ProfileLayout>
            <PrimeCard>
                <template #header>
                    <div class="border-b px-5 py-3">
                        <HeadingSmall :title="$t('avid::settings.profile')"
                            :description="$t('avid::settings.edit_your_profile_information')" />
                    </div>
                </template>

                <template #content>
                    <form @submit.prevent="submit" class="space-y-5">
                        <FieldText v-model="form.name" :label="$t('avid::form.name')" name="name" required
                            :error="form.errors.name" />

                        <FieldText v-model="form.email" :label="$t('avid::form.email')" name="email" type="email"
                            required :error="form.errors.email" />

                        <div v-if="mustVerifyEmail && !user.email_verified_at">
                            <p class="-mt-4 text-muted-foreground">
                                {{ $t('avid::settings.your_email_has_not_been_verified') }}
                                <Link :href="avidRoute('verification.send')" method="post" as="button"
                                    class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500">
                                {{ $t('avid::settings.click_here_to_resend_the_verification_link') }}
                                </Link>
                            </p>

                            <div v-if="status === 'verification-link-sent'" class="mt-2 font-medium text-green-600">
                                {{ $t('avid::settings.a_new_verification_link_has_been_sent_to_your_email_address') }}
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimeButton type="submit" :label="$t('avid::form.save')" :loading="form.processing"
                                :disabled="form.processing" />
                        </div>
                    </form>
                </template>
            </PrimeCard>
        </ProfileLayout>
    </MainLayout>
</template>
