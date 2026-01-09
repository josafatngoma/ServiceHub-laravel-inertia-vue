<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'status',
    ];

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

    // cada ticket tem apenas um detalhe técnico
    public function detail(): HasOne
    {
        return $this->hasOne(TicketDetail::class);
    } 
}
