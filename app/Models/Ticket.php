<?php

namespace App\Models;

use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{

    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'status',
    ];

    //transformando a string do banco no Enum automaticamente
    protected $casts = [
        'status' => TicketStatus::class,
    ];

    //enviar campos virtuais para o front-end
    protected $appends = [
        'status_label', 
        'status_classes'
    ];

    //acess para o Texto (acessado como ticket.status_label)
    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    //acessor da cor
    public function getStatusClassesAttribute(): string
    {
        return $this->status->color();
    }

    //cada ticket (chamado) pertence a um projeto
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    //cada ticket (chamado) pertence a um usuário (quem abriu o chamado)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //cada ticket tem apenas um detalhe técnico
    public function detail(): HasOne
    {
        return $this->hasOne(TicketDetail::class);
    } 
}
