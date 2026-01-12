<?php

use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

//uma empresa tem N projetos (1:N)
test('Uma empresa tem vários projetos (1:N)', function () {
    //criando uma empresa
    $company = Company::factory()->create();
    
    //criando 3 projetos para essa empresa
    $projects = Project::factory()->count(3)->create(['company_id' => $company->id]);

    //testando se a empresa possui 3 projetos
    expect($company->projects)->toHaveCount(3);
    expect($company->projects->first())->toBeInstanceOf(Project::class);
});

//projeto tem muitos tickets (1:N)
test('Um projeto tem vários tickets (1:N)', function () {
    //criando um projeto
    $project = Project::factory()->create();
    
    //criando 2 tickets para esse projeto
    Ticket::factory()->count(2)->create(['project_id' => $project->id]);

    expect($project->tickets)->toHaveCount(2);
    expect($project->tickets->first())->toBeInstanceOf(Ticket::class);
});