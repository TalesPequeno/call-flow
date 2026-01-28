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
}