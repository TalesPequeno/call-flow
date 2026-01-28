<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'user_id',
        'assigned_to',
        'sector',
        'closed_at',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Quem abriu o chamado
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Técnico responsável (pode ser null)
    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Histórico de mensagens do chamado
    public function messages()
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id')->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (filtros reutilizáveis)
    |--------------------------------------------------------------------------
    */

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopePriority(Builder $query, string $priority): Builder
    {
        return $query->where('priority', $priority);
    }

    // Chamados "ativos" (não encerrados)
    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNotIn('status', ['resolvido', 'fechado']);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (opcional)
    |--------------------------------------------------------------------------
    */

    public function isClosed(): bool
    {
        return in_array($this->status, ['resolvido', 'fechado'], true);
    }

    public function close(string $finalStatus = 'fechado'): void
    {
        $this->update([
            'status' => $finalStatus,
            'closed_at' => now(),
        ]);
    }
}