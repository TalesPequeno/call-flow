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
            $tickets = Ticket::forUser($user->id)
                ->latest()
                ->take(5)
                ->get();

            return view('dashboards.funcionario', [
                'user' => $user,
                'tickets' => $tickets,
            ]);
        }

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
