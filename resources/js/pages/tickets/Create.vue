<script setup lang="ts">
    import AppLayout from '@/layouts/AppLayout.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { type BreadcrumbItem } from '@/types';
    import { List, CirclePlus } from 'lucide-vue-next';
    import FlashMessage from '@/components/FlashMessage.vue';

    //listando os projetos no formulário
    defineProps<{
        projects: {id: number; name: string;}[];
    }>();

    //breadcrumbs
    const breadcrumbs: BreadcrumbItem[] = [
        {title: 'Tickets', href: route('tickets.index')},
        {title: 'Abrir Novo Ticket', href: ''},
    ];

    //definindo o formulário com valores iniciais
    const form = useForm({
        title: '',
        description: '',
        project_id: '',
        attachment_file: null as File | null,
    });

    const submit = () => {
        form.post(route('tickets.store'), {
            forceFormData: true,
        });
    };

    // manipulação do anexo
    const handleFileUpload = (event: Event) => {
        const target = event.target as HTMLInputElement;
        if (target.files && target.files.length > 0) {
            form.attachment_file = target.files[0];
        }
    };
</script>

<template>
    <Head title="Adicionar Novo Ticket" />
    <!-- usando o layout padrão -->
    <AppLayout :breadcrumbs="breadcrumbs">
        

        <div class="w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
    
            <div class="border-b border-gray-200 px-4 py-3 dark:border-zinc-800">
                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                    Abrir Novo Ticket
                </h3>
            </div>
            
            <FlashMessage />

            <div class="p-4">
                <form @submit.prevent="submit" class="grid gap-4">
                    
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        
                        <div class="space-y-1.5">
                            <label for="title" class="text-xs font-medium text-gray-900 dark:text-gray-300">
                                Título <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.title"
                                type="text"
                                id="title"
                                class="flex h-9 w-full rounded-md border border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-gray-950 dark:border-zinc-700 dark:text-gray-100 dark:focus-visible:ring-gray-300"
                                placeholder="Resumo do problema"
                                
                            />
                            <div v-if="form.errors.title" class="text-xs text-red-500">{{ form.errors.title }}</div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="project_id" class="text-xs font-medium text-gray-900 dark:text-gray-300">
                                Projeto <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="project_id"
                                    v-model="form.project_id"
                                    class="flex h-9 w-full appearance-none rounded-md border border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-gray-950 dark:border-zinc-700 dark:text-gray-100 dark:bg-zinc-900"
                                    
                                >
                                    <option value="" disabled class="text-gray-500">Selecione...</option>
                                    <option v-for="project in projects" :key="project.id" :value="project.id">
                                        {{ project.name }}
                                    </option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            <div v-if="form.errors.project_id" class="text-xs text-red-500">{{ form.errors.project_id }}</div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="description" class="text-xs font-medium text-gray-900 dark:text-gray-300">
                            Descrição
                        </label>
                        <textarea
                            v-model="form.description"
                            id="description"
                            rows="3"
                            class="flex min-h-[60px] w-full rounded-md border border-gray-300 bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-gray-950 dark:border-zinc-700 dark:text-gray-100 dark:focus-visible:ring-gray-300"
                            placeholder="Detalhes do problema..."
                        ></textarea>
                        <div v-if="form.errors.description" class="text-xs text-red-500">{{ form.errors.description }}</div>
                    </div>

                    <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-end">
                        
                        <div class="w-full space-y-1.5 md:w-2/3">
                            <label for="attachment_file" class="text-xs font-medium text-gray-900 dark:text-gray-300">
                                Anexo (JSON/TXT)
                            </label>
                            
                            <input
                                id="attachment_file"
                                type="file"
                                @change="handleFileUpload"
                                class="flex w-full rounded-md border border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:mr-4 file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-gray-950 disabled:cursor-not-allowed disabled:opacity-50 dark:border-zinc-700 dark:text-gray-100 dark:focus-visible:ring-gray-300 file:text-gray-900 dark:file:text-gray-100"
                                accept=".json,.txt,.pdf"
                            />

                            <div v-if="form.progress" class="h-1.5 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-zinc-700">
                                <div class="h-full bg-indigo-600 transition-all" :style="{ width: form.progress.percentage + '%' }"></div>
                            </div>

                            <div v-if="form.errors.attachment_file" class="text-xs text-red-500">
                                {{ form.errors.attachment_file }}
                            </div>
                        </div>

                        <div class="flex w-full justify-end md:w-auto">
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="inline-flex h-9 w-full items-center justify-center rounded-md bg-gray-900 px-6 text-sm font-medium text-gray-50 shadow hover:bg-gray-900/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-gray-950 disabled:opacity-50 md:w-auto dark:bg-gray-50 dark:text-gray-900"
                            >
                                <CirclePlus class="mr-2 h-4 w-4" />
                                <span>{{ form.processing ? '...' : 'Cadastrar' }}</span>
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>

    </AppLayout>
</template>