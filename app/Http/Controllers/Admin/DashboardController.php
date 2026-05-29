<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Voiture;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_voitures'      => Voiture::count(),
            'voitures_disponibles'=> Voiture::where('statut', 'Disponible')->count(),
            'voitures_louees'     => Voiture::where('statut', 'Louée')->count(),
            'total_clients'       => User::where('role', 'client')->count(),
            'total_reservations'  => Reservation::count(),
            'reservations_actives'=> Reservation::whereIn('statut', ['Confirmée', 'En cours'])->count(),
            'revenus_mois'        => Reservation::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->where('statut_paiement', 'Payé')
                                        ->sum('prix_total'),
            'revenus_total'       => Reservation::where('statut_paiement', 'Payé')->sum('prix_total'),
        ];

        $reservations_recentes = Reservation::with(['user', 'voiture'])
            ->latest()->limit(5)->get();

        $voitures_populaires = Voiture::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(5)->get();

        // Revenus des 6 derniers mois
        $revenus_mensuels = [];
        for ($i = 5; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $revenus_mensuels[] = [
                'mois'   => $mois->format('M Y'),
                'revenu' => Reservation::whereMonth('created_at', $mois->month)
                                ->whereYear('created_at', $mois->year)
                                ->where('statut_paiement', 'Payé')
                                ->sum('prix_total'),
            ];
        }

        return view('admin.dashboard', compact('stats', 'reservations_recentes', 'voitures_populaires', 'revenus_mensuels'));
    }
}
