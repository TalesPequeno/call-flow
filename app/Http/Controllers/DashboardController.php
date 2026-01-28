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

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
