<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { type BreadcrumbItem } from '@/types';
    import { List, Pencil } from 'lucide-vue-next';
    import DeleteButton from '@/components/DeleteButton.vue';

    //definindo a interface Ticket
    export interface Ticket {
        id: number;
        title: string;
        description: string;
        status: string;
        created_at: string;
        project: {
            id: number;
            name: string;
        };
        user: {
            id: number;
            name: string;
        };
    }

    const props = defineProps<{
        ticket: Ticket;
    }>();

    //breadcrumbs
    const breadcrumbs: BreadcrumbItem[] = [
        {title: 'Tickets', href: '/tickets'},
        {title: 'Detalhes do Ticket', href: ''},
    ];
</script>

<template>
    <Head title="Detalhes do Ticket" />
    <!-- usando o layout padrão -->
    <AppLayout :breadcrumbs="breadcrumbs">
        

        <div class="w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-zinc-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Detalhes do Ticket
                </h3>
                
                <div class="flex items-center gap-2">
                    <Link
                        :href="`/tickets/${ticket.id}/edit`"
                        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-gray-300 dark:hover:bg-zinc-700"
                    >
                        <Pencil class="h-4 w-4" />
                        <span>Editar</span>
                    </Link>
                    
                    <DeleteButton
                        :url="`/tickets/${ticket.id}`"
                        title="Tem a certeza que deseja apagar este ticket?"
                        class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:hover:bg-red-500"
                    />
                </div>
            </div>

            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ ticket.title }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Ticket #{{ ticket.id }} • Criado em {{ new Date(ticket.created_at).toLocaleString() }}
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-x-4 gap-y-6 rounded-lg border border-gray-100 bg-gray-50 p-4 sm:grid-cols-2 lg:grid-cols-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                    
                    <div>
                        <span class="block text-xs font-medium uppercase text-gray-500 dark:text-gray-400">Projeto</span>
                        <span class="mt-1 block text-sm font-medium text-gray-900 dark:text-gray-200">
                            {{ ticket.project.name }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-xs font-medium uppercase text-gray-500 dark:text-gray-400">Solicitante</span>
                        <div class="mt-1 flex items-center gap-2">
                            <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300">
                                {{ ticket.user.name.charAt(0) }}
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                {{ ticket.user.name }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="block text-xs font-medium uppercase text-gray-500 dark:text-gray-400">Status Atual</span>
                        <span 
                            class="px-2 py-1 rounded-full text-xs font-medium"
                            :class="ticket.status_classes" 
                        >
                            {{ ticket.status_label }}
                        </span>
                    </div>
                </div>

                <div class="mt-8">
                    <h4 class="mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Descrição Detalhada</h4>
                    <div class="rounded-lg border border-gray-200 bg-white p-4 text-sm text-gray-600 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300">
                        <p class="whitespace-pre-wrap">{{ ticket.description }}</p>
                    </div>
                </div>

            </div>
        </div>

    </AppLayout>
</template>