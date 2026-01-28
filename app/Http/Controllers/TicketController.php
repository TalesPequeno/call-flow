<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
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

    public function respond(Request $request, Ticket $ticket)
    {
        if ($request->user()->role !== 'tecnico') {
            abort(403);
        }

        if ($ticket->assigned_to && $ticket->assigned_to !== $request->user()->id) {
            abort(403);
        }

        if (!$ticket->assigned_to && $ticket->status === 'aberto') {
            $ticket->update([
                'status' => 'em_atendimento',
                'assigned_to' => $request->user()->id,
            ]);
        }

        $ticket->load(['owner', 'technician', 'messages.user']);

        return view('tickets.respond', [
            'ticket' => $ticket,
        ]);
    }

    public function storeMessage(Request $request, Ticket $ticket)
    {
        if ($request->user()->role !== 'tecnico') {
            abort(403);
        }

        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        $isFirstMessage = $ticket->messages()->count() === 0;

        $ticket->messages()->create([
            'user_id' => $request->user()->id,
            'message' => $data['message'],
        ]);

        if ($isFirstMessage) {
            $ticket->update([
                'status' => 'em_atendimento',
                'assigned_to' => $request->user()->id,
            ]);
        }

        return redirect()
            ->route('tickets.respond', $ticket)
            ->with('success', 'Resposta enviada com sucesso!');
    }
}
