<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Executando a criação de dados na tabela de projetos.
     */
    public function run(): void
    {
        Project::insert([
            [
                'name' => 'ProSales',
                'description' => 'Software de gestão de vendas',
                'status' => 'active',
                'company_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SecureIT',
                'description' => 'Antivírus e segurança cibernética',
                'status' => 'active',
                'company_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'kTV+',
                'description' => 'Plataforma de streaming de vídeo',
                'status' => 'active',
                'company_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
