<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        $isOwner = $ticket->user_id === $user->id;
        $isTechnician = $ticket->assigned_to === $user->id;
        $isAdmin = $user->role === 'admin';

        if (!($isOwner || $isTechnician || $isAdmin)) {
            abort(403);
        }

        if ($user->role === 'tecnico' && !$ticket->assigned_to && $ticket->status === 'aberto') {
            $ticket->update([
                'status' => 'em_atendimento',
                'assigned_to' => $user->id,
            ]);
        }

        $ticket->load(['owner', 'technician', 'messages.user']);

        return view('tickets.show', [
            'ticket' => $ticket,
        ]);
    }

    public function store(StoreTicketRequest $request)
    {
        $data = $request->validated();

        Ticket::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'] ?? 'media',
            'sector' => $data['sector'] ?? null,
            'status' => 'aberto',
            'user_id' => auth()->id(),
            'assigned_to' => null,
            'closed_at' => null,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Chamado criado com sucesso!');
    }

    public function storeMessage(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        $isOwner = $ticket->user_id === $user->id;
        $isTechnician = $ticket->assigned_to === $user->id;
        $isAdmin = $user->role === 'admin';

        if (!($isOwner || $isTechnician || $isAdmin)) {
            abort(403);
        }

        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        $isFirstMessage = $ticket->messages()->count() === 0;

        $ticket->messages()->create([
            'user_id' => $user->id,
            'message' => $data['message'],
        ]);

        if ($user->role === 'tecnico') {
            $ticket->update([
                'status' => 'em_atendimento',
                'assigned_to' => $isFirstMessage ? $user->id : $ticket->assigned_to,
            ]);
        } elseif ($user->role === 'admin') {
            $ticket->update([
                'status' => 'em_atendimento',
            ]);
        } elseif ($user->role === 'funcionario') {
            $ticket->update([
                'status' => 'aguardando',
            ]);
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Resposta enviada com sucesso!');
    }
}
