<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'funcionario') {
            $userTicketsQuery = Ticket::forUser($user->id);

            $stats = [
                'total' => (clone $userTicketsQuery)->count(),
                'abertos' => (clone $userTicketsQuery)->status('aberto')->count(),
                'em_atendimento' => (clone $userTicketsQuery)->status('em_atendimento')->count(),
                'resolvidos' => (clone $userTicketsQuery)->status('resolvido')->count(),
            ];

            $tickets = (clone $userTicketsQuery)
                ->latest()
                ->take(5)
                ->get();

            return view('dashboards.funcionario', [
                'user' => $user,
                'tickets' => $tickets,
                'stats' => $stats,
            ]);
        }

        if ($user->role === 'tecnico') {
            $openTicketsQuery = Ticket::status('aberto');
            $myTicketsQuery = Ticket::where('assigned_to', $user->id);

            $stats = [
                'abertos' => (clone $openTicketsQuery)->count(),
                'em_atendimento' => (clone $myTicketsQuery)->status('em_atendimento')->count(),
                'aguardando' => (clone $myTicketsQuery)->status('aguardando')->count(),
                'resolvidos' => (clone $myTicketsQuery)->status('resolvido')->count(),
            ];

            $openTickets = (clone $openTicketsQuery)
                ->latest()
                ->take(6)
                ->get();

            $myTickets = (clone $myTicketsQuery)
                ->whereIn('status', ['em_atendimento', 'aguardando'])
                ->latest()
                ->take(6)
                ->get();

            return view('dashboards.tecnico', [
                'user' => $user,
                'stats' => $stats,
                'openTickets' => $openTickets,
                'myTickets' => $myTickets,
            ]);
        }

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
