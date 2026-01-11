<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Executando criação de dados na tabela de tickets (chamados).
     */
    public function run(): void
    {
        Ticket::insert([
            [
                'project_id' => 1,
                'user_id' => 1,
                'title' => 'Erro ao acessar o sistema',
                'description' => 'Estou enfrentando um erro ao tentar acessar o sistema. Por favor, ajudem-me a resolver isso.',
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => 2,
                'user_id' => 1,
                'title' => 'Solicitação de nova funcionalidade',
                'description' => 'Gostaria de sugerir uma nova funcionalidade para melhorar a experiência do usuário.',
                'status' => 'in_progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
