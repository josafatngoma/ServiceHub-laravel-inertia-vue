<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTicketAttachment;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{

    //listar os tickets (chamados)
    public function index()
    {
        //buscando todos os tickets, sem limitar a visualização por usuário logado
        $tickets = Ticket::with(['user:id,name', 'project:id,name'])->orderBy('created_at', 'desc')->paginate(5);
        return Inertia::render('tickets/Index', [
            'tickets' => $tickets,
        ]);
    }

    //mostrar detalhes do ticket (chamado)
    public function show(Ticket $ticket)
    {
        return Inertia::render('tickets/Show', [
            'ticket' => $ticket->load(['user:id,name', 'project:id,name']),
        ]);
    }

    //listando os projetos no formulario de criação de tickets (chamados)
    public function create(): Response
    {
        $projects = Project::where('status', 'active')->select('id', 'name')->get();
        return Inertia::render('tickets/Create', [
            'projects' => $projects,
        ]);
    }

    //salvando o ticket (chamado) + upload no banco de dados
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'project_id' => 'required|exists:projects,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'attachment_file' => 'nullable|file|mimes:json,txt|max:2048',
            ],
            [
                'project_id.required' => 'O campo projeto é obrigatório.',
                'project_id.exists' => 'O projeto selecionado é inválido.',
                'title.required' => 'O campo título é obrigatório.',
                'title.max' => 'O campo título não pode exceder 255 caracteres.',
                'description.required' => 'O campo descrição é obrigatório.',
                'attachment_file.file' => 'O anexo deve ser um arquivo válido.',
                'attachment_file.mimes' => 'O anexo deve ser um arquivo do tipo: json, txt.',
                'attachment_file.max' => 'O anexo não pode exceder 2MB.',
            ]
        );

        try {
            //certificando que insere em todas as tabelas ou nenhuma
            $ticket = DB::transaction(function () use ($validatedData, $request) {

                //criando o ticket
                $ticket = Auth::user()->tickets()->create([
                    'project_id' => $validatedData['project_id'],
                    'title' => $validatedData['title'],
                    'description' => $validatedData['description'],
                    'status' => 'open',
                ]);

                //upload do arquivo
                $path = null;
                if ($request->hasFile('attachment_file')) {
                    //salvando upload em "ticket_anexos", caminho "storage/app/ticket_anexos"
                    $path = $request->file('attachment_file')->store('ticket_anexos');
                }

                //criando o ticket detail (detalhes do chamado)
                $ticket->detail()->create([
                    'attachment_file' => $path,
                    'json_upload_data' => null, //processamento com Jobs
                    'msg_upload' => 'Carregando...',
                ]);

                //disparando o job para processar o arquivo upload
                ProcessTicketAttachment::dispatch($ticket);

                return $ticket;
            });

            return redirect()->route('tickets.show', ['ticket' => $ticket->id])->with('success', 'Chamado aberto com sucesso! <br> O anexo está em processamento.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao abrir o chamado: ' . $e->getMessage()]);
        }
    }
}
