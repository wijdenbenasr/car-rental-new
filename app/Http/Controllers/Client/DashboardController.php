<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reservations = Reservation::with('voiture')
            ->where('user_id', $user->id)
            ->latest()->limit(5)->get();

        $stats = [
            'total'     => Reservation::where('user_id', $user->id)->count(),
            'actives'   => Reservation::where('user_id', $user->id)->whereIn('statut', ['Confirmée', 'En cours'])->count(),
            'terminees' => Reservation::where('user_id', $user->id)->where('statut', 'Terminée')->count(),
            'depenses'  => Reservation::where('user_id', $user->id)->where('statut_paiement', 'Payé')->sum('prix_total'),
        ];

        return view('client.dashboard', compact('reservations', 'stats'));
    }
}
