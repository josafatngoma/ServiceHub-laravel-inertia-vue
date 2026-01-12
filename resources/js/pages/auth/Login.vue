<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <AuthBase
        title="Acesse sua conta"
        description="Informe suas credenciais para continuar"
    >
        <Head title="Login" />

        <div
            v-if="status"
            class="mb-4 rounded-md bg-green-50 p-3 text-center text-sm font-medium text-green-600 dark:bg-green-900/20 dark:text-green-400"
        >
            {{ status }}
        </div>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                
                <div class="grid gap-2">
                    <Label for="email">E-mail</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="seu@email.com"
                        class="bg-white dark:bg-zinc-900"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Senha</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-xs font-medium text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200"
                            :tabindex="5"
                        >
                            Esqueceu a senha?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="bg-white dark:bg-zinc-900"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-2.5 cursor-pointer">
                        <Checkbox 
                            id="remember" 
                            name="remember" 
                            :tabindex="3" 
                            class="rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:ring-offset-zinc-900"
                        />
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Lembrar de mim</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full bg-zinc-900 text-white transition-all hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200"
                    :tabindex="4"
                    :disabled="processing"
                    data-test="login-button"
                >
                    <Spinner v-if="processing" class="mr-2 h-4 w-4" />
                    Entrar
                </Button>
            </div>

            <div
                class="text-center text-sm text-zinc-500 dark:text-zinc-400"
                v-if="canRegister"
            >
                Não tem uma conta?
                <TextLink 
                    :href="register()" 
                    :tabindex="5"
                    class="font-medium text-zinc-900 underline underline-offset-4 hover:text-zinc-700 dark:text-zinc-100 dark:hover:text-zinc-300"
                >
                    Cadastre-se
                </TextLink>
            </div>
        </Form>
    </AuthBase>
</template>