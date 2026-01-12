<?php

use App\Models\Ticket;
use App\Models\User;
use App\Models\Project;
use App\Enums\TicketStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

//relacionamento: ticket pertence a User
test('Ticket prtence a um usuário', function () {
    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);

    //testando se o relacionamento do Eloquent funciona
    expect($ticket->user)->toBeInstanceOf(User::class);
    expect($ticket->user->id)->toBe($user->id);
});

//relacionamkento: ticket pertence a Project
test('Ticket pertence a um projeto', function () {
    $project = Project::factory()->create();
    $ticket = Ticket::factory()->create(['project_id' => $project->id]);

    expect($ticket->project)->toBeInstanceOf(Project::class);
});

//lógica: tradução do status / arquivo pasta aap/Enums/TicketStatus.php
test('Status do ticket retorna em português e uma cor específica', function () {
    //criando ticket com status 'open'
    $ticket = Ticket::factory()->create(['status' => TicketStatus::OPEN]);

    //verificando se traduziu corretamente para 'Aberto'
    expect($ticket->status_label)->toBe('Aberto');
    
    //verificando se a classe da cor está correta
    expect($ticket->status_classes)->toContain('bg-blue-100');
});