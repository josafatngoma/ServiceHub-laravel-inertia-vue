<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';

    // para retornar o texto traduzido
    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Aberto',
            self::IN_PROGRESS => 'Em Progresso',
            self::RESOLVED => 'Resolvido',
        };
    }

    // para retornar a cor associada ao status do ticket
    public function color(): string
    {
        return match ($this) {
            self::OPEN => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200',
            self::IN_PROGRESS => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200',
            self::RESOLVED => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200',
            self::CLOSED => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        };
    }
}