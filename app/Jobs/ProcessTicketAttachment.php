<?php

namespace App\Jobs;

use App\Models\Ticket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessTicketAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Ticket $ticket)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Iniciando o processamento do Ticket ID: {$this->ticket->id}");

        // Recarregar o ticket com os detalhes relacionados
        $this->ticket->load('detail');
        $detail = $this->ticket->detail;

        // Verificar se não há um arquivo anexado
        if (!$detail || !$detail->attachment_file) {
            Log::warning("Ticket ID: {$this->ticket->id} não possui arquivo anexado para processar.");
            return;
        }

        // lendo o conteúdo do arquivo anexado
        if (Storage::exists($detail->attachment_file)) {
            $fileContent = Storage::get($detail->attachment_file);

            // decodificando o conteúdo JSON
            $jsonData = json_decode($fileContent, true);

            // Atualizando os detalhes do ticket com os dados processados
            $proccessedData = $jsonData ? $jsonData : ['raw_content' => $fileContent];
            $detail->update([
                'json_upload_data' => $proccessedData,
                'msg_upload' => 'Processamento concluído com sucesso.',
            ]);

            //mudando o status do ticket
            $this->ticket->update(['status' => 'in_progress']);

            $this->ticket->user->notify(new \App\Notifications\TicketProcessed($this->ticket));

            //notificando o usuário responsável
            Log::info("Notificação enviada para o responsável do Ticket #:{$this->ticket->id}");
        }else {
            Log::error("Arquivo anexado não encontrado para o Ticket #:{$this->ticket->id}");
            $detail->update([
                'msg_upload' => 'Erro: Arquivo anexado não encontrado.',
            ]);
        }
            
    }
}
