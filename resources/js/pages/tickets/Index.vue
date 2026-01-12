<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { Head, Link, router } from '@inertiajs/vue3';
    import { type BreadcrumbItem } from '@/types';
    import { CirclePlus, Eye, Pencil } from 'lucide-vue-next';
    import Pagination from '@/components/Pagination.vue';
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
        tickets: {
            data: Ticket[];
            links: {url: string | null; label: string; active: boolean;}
        }
    }>();

    //breadcrumbs
    const breadcrumbs: BreadcrumbItem[] = [
        {title: 'Tickets', href: ''},
    ];
</script>

<template>
    <Head title="Tickets" />
    <!-- usando o layout padrão -->
    <AppLayout :breadcrumbs="breadcrumbs">
        

        <div class="w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-zinc-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Tickets</h3>
                <div class="flex items-center gap-2">
                    <Link
                        :href="route('tickets.create')"
                        class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:hover:bg-green-500"
                    >
                        <CirclePlus class="h-4 w-4" />
                        <span>Abrir Novo Chamado</span>
                    </Link>
                </div>
            </div>

            <div class="relative w-full overflow-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-zinc-800/50 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">Título</th>
                            <th scope="col" class="px-6 py-3 font-medium">Projeto</th>
                            <th scope="col" class="px-6 py-3 font-medium">Status</th>
                            <th scope="col" class="px-6 py-3 font-medium">Criado em</th>
                            <th scope="col" class="px-6 py-3 font-medium text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800">
                        <tr 
                            v-for="ticket in props.tickets.data" 
                            :key="ticket.id" 
                            class="bg-white hover:bg-gray-50 dark:bg-zinc-900 dark:hover:bg-zinc-800/50"
                        >
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                                {{ ticket.title }}
                            </td>
                            <td class="px-6 py-4">
                                {{ ticket.project.name }}
                            </td>
                            <td class="px-6 py-4">
                                <span 
                                    class="px-2 py-1 rounded-full text-xs font-medium"
                                    :class="ticket.status_classes" 
                                >
                                    {{ ticket.status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ new Date(ticket.created_at).toLocaleDateString() }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <Link
                                        :href="`/tickets/${ticket.id}`"
                                        class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-gray-300 dark:hover:bg-zinc-700"
                                    >
                                        <Eye class="h-3 w-3" />
                                        <span>Ver</span>
                                    </Link>
                                    
                                    <Link
                                        :href="`/tickets/${ticket.id}/edit`"
                                        class="inline-flex items-center gap-1 rounded border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-gray-300 dark:hover:bg-zinc-700"
                                    >
                                        <Pencil class="h-3 w-3" />
                                        <span>Editar</span>
                                    </Link>

                                    <DeleteButton
                                        :url="`/tickets/${ticket.id}`"
                                        title="Apagar Ticket"
                                        buttonText="Apagar"
                                        class="inline-flex items-center gap-1 rounded bg-red-600 px-2 py-1 text-xs font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:hover:bg-red-500"
                                    /> 
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="border-t border-gray-200 px-6 py-4 dark:border-zinc-800">
                    <Pagination :links="props.tickets.links" />
                </div>
            
            </div>

        </div>

    </AppLayout>
</template>