<?php

use App\Jobs\ProcessTicketAttachment;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketProcessed;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

//test para criação de tickets
test('Apenas usuários autenticados podem criar tickets', function () {
    //arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();
    
    //act
    $response = $this->actingAs($user)->post(route('tickets.store'), [
        'title' => 'As definições do software não abrem corretamente',
        'description' => 'Ao tentar abrir as definições do software, a janela não carrega e permanece em branco.',
        'project_id' => $project->id,
    ]);

    //assert
    $this->assertDatabaseHas('tickets', [
        'title' => 'As definições do software não abrem corretamente',
        'description' => 'Ao tentar abrir as definições do software, a janela não carrega e permanece em branco.',
        'project_id' => $project->id,
        'status' => 'open',
    ]);

    //redirect to ticket details page
    $ticket = Ticket::where('title', 'As definições do software não abrem corretamente')->first();
    $response->assertRedirect(route('tickets.show', $ticket->id));
    $response->assertSessionHas('success');    
});

//test validando campos obrigatórios
test('Ticket rquer title, description, e project_id', function (){
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('tickets.store'), [
        'title' => '',
        'description' => '',
        'project_id' => '',
    ]);

    $response->assertSessionHasErrors(['title', 'description', 'project_id']);
});

//test para anexar arquivo e enviar notificação
test('Ticket pode ter um anexo e enviar notificação', function () {
    Storage::fake('local');
    Notification::fake();  
    Queue::fake();         

    $user = User::factory()->create();
    $project = Project::factory()->create();

    //crie um arquivo falso para upload
    $file = UploadedFile::fake()->create('log_erro.json', 100, 'application/json');

    //agir
    $this->actingAs($user)->post(route('tickets.store'), [
        'title' => 'Erro com Anexo',
        'description' => 'Segue log anexo.',
        'project_id' => $project->id,
        'attachment_file' => $file,
    ]);

    //verificando seu o anexo foi salvo e o job foi despachado
    $ticket = Ticket::first();
    //verificando se o anexo tem caminho salvo no banco
    expect($ticket->detail->attachment_file)->not->toBeNull();

    //verifcando se o job foi para a fila
    Queue::assertPushed(ProcessTicketAttachment::class);
});

test('Job processa o arquivo e envia notificação', function () {
    Notification::fake();
    Storage::fake();

    //criando os dados
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $ticket = Ticket::create([
        'user_id' => $user->id,
        'project_id' => $project->id,
        'title' => 'Teste Job',
        'description' => 'Desc',
        'status' => 'open'
    ]);
    
    $path = 'ticket_anexos/teste.json';
    Storage::put($path, json_encode(['error' => 404]));
    
    $ticket->detail()->create([
        'attachment_file' => 'ticket_anexos/teste.json',
        'msg_upload' => 'Carregando...'
    ]);

    ///Salvando o arquivo no disco fake
    Storage::put($path, json_encode(['erro' => 404]));

    //salvando o caminho no bd
    $ticket->detail()->create([
        'attachment_file' => $path,
        'msg_upload' => 'Carregando...'
    ]);

    //executando o Job
    $job = new ProcessTicketAttachment($ticket);
    $job->handle();

    //verificando se a notificação foi enviada
    Notification::assertSentTo($user, TicketProcessed::class);
});