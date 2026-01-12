<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketProcessed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     * recebendo os dados do ticket
     */
    public function __construct(public Ticket $ticket)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     * definindo os canais da notificação
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     * configurando o email da notificação 
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Anexo : #' . $this->ticket->id .' Processado')
            ->greeting('Olá ' . $notifiable->name)
            ->line('O anexo do seu ticket #' . $this->ticket->id . ' foi processado com sucesso.')
            ->line('Status atual do ticket: ' . ($this->ticket->status->value ?? $this->ticket->status))
            ->line('Você pode visualizar os detalhes do ticket clicando no botão abaixo.')
            ->action('Ver Ticket', route('tickets.show', $this->ticket->id))
            ->line('Obrigado por usar nossa aplicação!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => 'Anexo #' . $this->ticket->title . ' Processado',
            'message' => 'O sistema leu o arquivo do seu ticket #' . $this->ticket->id . ' com sucesso.',
            'link' => route('tickets.show', $this->ticket->id),
        ];
    }
}
