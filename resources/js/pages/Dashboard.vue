<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Ticket, Clock, CheckCircle2, Plus, ArrowRight } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

// Dados Mockados apenas para visualização (depois virão do Backend)
const stats = [
    { label: 'Total de Tickets', value: '24', icon: Ticket, desc: 'Histórico completo' },
    { label: 'Em Aberto', value: '5', icon: Clock, desc: 'Aguardando ação', color: 'text-amber-600' },
    { label: 'Resolvidos', value: '19', icon: CheckCircle2, desc: 'Finalizados com sucesso', color: 'text-green-600' },
];

const recentTickets = [
    { id: 105, title: 'Erro na integração de API', project: 'Alpha Corp', status: 'Aberto', date: 'Hoje, 10:30' },
    { id: 104, title: 'Ajuste de CSS na Landing Page', project: 'Beta Ltda', status: 'Em Progresso', date: 'Ontem' },
    { id: 103, title: 'Backup do banco de dados', project: 'Alpha Corp', status: 'Concluído', date: '10/01/2026' },
];
</script>

<template>
    <Head title="Dashboard" />
    <!-- DADOS FAKES -->
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4 md:p-6">
            
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Visão Geral</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Acompanhe o status dos seus serviços.</p>
                </div>
                <Link 
                    :href="route('tickets.create')"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white shadow hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200"
                >
                    <Plus class="h-4 w-4" />
                    Novo Ticket
                </Link>
            </div>

        </div>
    </AppLayout>
</template>