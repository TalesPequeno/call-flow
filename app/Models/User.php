<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos que podem ser preenchidos em massa
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'sector',
    ];

    /**
     * Campos ocultos
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    // Chamados que o usuário abriu
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    // Chamados atribuídos a ele (técnico)
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    // Mensagens que ele escreveu nos chamados
    public function ticketMessages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS DE PERFIL (RBAC SIMPLES)
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTecnico(): bool
    {
        return $this->role === 'tecnico';
    }

    public function isFuncionario(): bool
    {
        return $this->role === 'funcionario';
    }
}
