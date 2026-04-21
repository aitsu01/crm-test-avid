<script setup lang="ts">
import { FieldPassword, FieldText } from '@/avid/components/form';
import TextLink from '@/avid/components/TextLink.vue';
import AuthBase from '@/avid/layouts/AuthLayout.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(avidRoute('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthBase title="Crea un account" description="Inserisci i tuoi dati qui sotto per creare il tuo account">
        <Head title="Registrazione" />

        <PrimeCard>
            <template #content>
                <form @submit.prevent="submit" class="flex flex-col gap-6">
                    <div class="grid gap-6">
                        <FieldText v-model="form.name" label="Nome" name="name" required :error="form.errors.name" />

                        <FieldText v-model="form.email" label="Email" name="email" type="email" required :error="form.errors.email" />

                        <FieldPassword v-model="form.password" label="Password" name="password" required :error="form.errors.password" />

                        <FieldPassword
                            v-model="form.password_confirmation"
                            label="Conferma password"
                            name="password_confirmation"
                            required
                            :error="form.errors.password_confirmation"
                        />

                        <PrimeButton type="submit" label="Create account" :loading="form.processing" :disabled="form.processing" />
                    </div>

                    <div class="text-center text-sm text-muted-foreground">
                        Hai già un account?
                        <TextLink :href="avidRoute('login')" class="underline underline-offset-4" :tabindex="6">Accedi</TextLink>
                    </div>
                </form>
            </template>
        </PrimeCard>
    </AuthBase>
</template>
