<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const success = computed(() => page.props.flash?.success);

const error = computed(() => page.props.flash?.error);

</script>

<template>
    <!-- div principal das mensagens -->
    <div class="mb-4">
        <!-- Exibe o bloco de mensagem de sucesso, se existir -->
        <div v-if="success" class="p-3 my-3 text-sm text-green-800 rounded-lg bg-green-100 border border-green-200">
            <!-- Mostra o texto da mensagem de sucesso -->
            {{ success }}
        </div>

        <!-- Exibe o bloco de mensagem de erro, se existir -->
        <div v-if="error" class="p-3 my-3 text-sm text-red-800 rounded-lg bg-red-100 border border-red-200">
            <!-- Mostra o texto da mensagem de erro -->
            {{ error }}
        </div>

    </div>

</template>