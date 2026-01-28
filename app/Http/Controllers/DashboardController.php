<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'funcionario') {
            return view('dashboards.funcionario', [
                'user' => $user,
                // 'tickets' => $tickets,
            ]);
        }

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
