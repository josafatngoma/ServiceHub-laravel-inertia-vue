<script setup lang="ts">
import { dashboard, login, register } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex min-h-screen flex-col items-center justify-center bg-gray-50 text-black/50 dark:bg-zinc-950 dark:text-white/50 selection:bg-indigo-500 selection:text-white">
        
        <div class="absolute inset-0 -z-10 h-full w-full bg-white dark:bg-zinc-950 [background:radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] dark:[background:radial-gradient(#ffffff05_1px,transparent_1px)]"></div>

        <div v-if="canLogin" class="fixed top-0 right-0 p-6 text-end z-10">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Dashboard
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Register
                </Link>
            </template>
        </div>

        <div class="w-full max-w-2xl px-6 lg:max-w-7xl">
            <div class="flex flex-col items-center justify-center text-center">
                
                <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-zinc-900 text-white shadow-lg dark:bg-white dark:text-zinc-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v4.086c0 .705.324 1.38.891 1.848l9.15 7.625c.813.677 2.035.534 2.68-.278l6.096-7.62c.594-.743.518-1.815-.168-2.457L12.56 2.65a1.87 1.87 0 0 0-1.189-.5H4.5c-.621 0-1.125.504-1.125 1.125Z" />
                    </svg>
                </div>

                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 sm:text-6xl dark:text-white">
                    ServiceHub
                </h1>

                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400 max-w-lg">
                    Gestão centralizada de ordens de serviço. Organize projetos, processe tickets e acompanhe detalhes técnicos em um único lugar.
                </p>

                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <template v-if="$page.props.auth.user">
                        <Link :href="route('dashboard')" class="rounded-md bg-zinc-900 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-zinc-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                            Acessar Painel
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="rounded-md bg-zinc-900 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-zinc-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                            Entrar
                        </Link>
                        <Link v-if="canRegister" :href="route('register')" class="text-sm font-semibold leading-6 text-zinc-900 hover:text-zinc-600 dark:text-zinc-100 dark:hover:text-zinc-300">
                            Criar conta <span aria-hidden="true">→</span>
                        </Link>
                    </template>
                </div>
            </div>
        </div>

        <footer class="absolute bottom-4 w-full text-center text-sm text-zinc-400 dark:text-zinc-600">
            ServiceHub &copy; {{ new Date().getFullYear() }}
        </footer>
    </div>
</template>