<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTicketAttachment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    //listando os projetos no formulario de criação de tickets (chamados)
    public function create(): Response
    {
        $projects = Project::where('status', 'active')->select('id', 'name')->get();
        return Inertia::render('Tickets/Create', [
            'projects' => $projects,
        ]);
    }

    //salvando o ticket (chamado) + upload no banco de dados
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'attachment_file' => 'nullable|file|mimes:josn,txt|max:2048',
        ]);

        try {
            //certificando que insere em todas as tabelas ou nenhuma
            DB::transaction(function () use ($validatedData, $request) {

                //criando o ticket
                $ticket = Auth::user()->tickets()->create([
                    'project_id' => $validatedData['project_id'],
                    'title' => $validatedData['title'],
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

            });

            return redirect()->route('tickets.index')->with('success', 'Chamado aberto com sucesso! <br> O anexo está em processamento.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao abrir o chamado: ' . $e->getMessage()]);
        }
    }
}
