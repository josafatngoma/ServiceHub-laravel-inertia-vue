<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Executando a criação de dados na tabela de empresas.
     */
    public function run(): void
    {
        Company::insert([
            [
                'name' => 'KPMG Brasil',
                'address' => 'Rua das Flores, 123',
                'phone_number' => '(11) 98765-4321',
                'document_number' => '111.222.333/4444-55',
            ],
        ]); 
    }
}
