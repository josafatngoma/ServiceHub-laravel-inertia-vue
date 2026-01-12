<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage, Link } from '@inertiajs/vue3';
import { Bell } from 'lucide-vue-next';

// acessando as notificações do usuário autenticado
const page = usePage();
const notifications = page.props.auth.notifications || [];

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        
        <div class="fixed top-3 right-4 z-50 ml-3">
            
            <div class="relative inline-flex items-center p-2 rounded-full bg-white/80 backdrop-blur-sm border border-gray-200 shadow-sm hover:bg-gray-100 dark:bg-zinc-900/80 dark:border-zinc-700 dark:hover:bg-zinc-800 cursor-pointer group transition-all">
                <Bell class="w-5 h-5 text-gray-600 dark:text-gray-300" />
                
                <span v-if="notifications.length > 0" class="absolute top-0 right-0 flex h-4 w-4 -mt-1 -mr-1 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white dark:ring-zinc-900">
                    {{ notifications.length }}
                </span>
    
                <div class="absolute right-0 top-full mt-2 w-80 origin-top-right rounded-xl bg-white py-1 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none hidden group-hover:block dark:bg-zinc-900 dark:ring-zinc-700 border border-gray-100 dark:border-zinc-700">
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-zinc-700 bg-gray-50/50 dark:bg-zinc-800/50 rounded-t-xl">
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Notificações</p>
                    </div>
                    
                    <div v-if="notifications.length === 0" class="px-4 py-8 text-center text-sm text-gray-500">
                        Nenhuma notificação nova.
                    </div>
    
                    <div v-else class="max-h-[300px] overflow-y-auto custom-scrollbar">
                        <Link 
                            v-for="notification in notifications" 
                            :key="notification.id"
                            :href="notification.data.link" 
                            class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors border-b border-gray-100 last:border-0 dark:border-zinc-800"
                        >
                            <div class="flex gap-3">
                                <div class="mt-1.5 h-2 w-2 flex-shrink-0 rounded-full bg-blue-600"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ notification.data.title }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                        {{ notification.data.message }}
                                    </p>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
        
        <slot />
    </AppLayout>
</template>
