<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Voiture;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('voiture')
            ->where('user_id', Auth::id())
            ->latest()->paginate(10);
        return view('client.reservations.index', compact('reservations'));
    }

    public function create(Voiture $voiture)
    {
        if (!$voiture->isDisponible()) {
            return back()->with('error', "Cette voiture n'est plus disponible.");
        }
        return view('client.reservations.create', compact('voiture'));
    }

    public function store(Request $request, Voiture $voiture)
    {
        $data = $request->validate([
            'date_debut'           => 'required|date|after_or_equal:today',
            'date_fin'             => 'required|date|after:date_debut',
            'lieu_prise_en_charge' => 'required|string|max:255',
            'lieu_retour'          => 'required|string|max:255',
            'notes'                => 'nullable|string',
        ]);

        $nb_jours   = Carbon::parse($data['date_debut'])->diffInDays($data['date_fin']);
        $prix_total = $nb_jours * $voiture->prix_par_jour;

        Reservation::create(array_merge($data, [
            'numero_reservation' => Reservation::generateNumero(),
            'user_id'            => Auth::id(),
            'voiture_id'         => $voiture->id,
            'nb_jours'           => $nb_jours,
            'prix_total'         => $prix_total,
            'caution'            => $voiture->prix_par_jour * 2,
            'statut'             => 'En attente',
            'statut_paiement'    => 'Non payé',
        ]));

        return redirect()->route('client.reservations.index')
            ->with('success', 'Réservation envoyée ! Nous vous contacterons bientôt.');
    }

    public function show(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) abort(403);
        $reservation->load('voiture');
        return view('client.reservations.show', compact('reservation'));
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) abort(403);
        if (!in_array($reservation->statut, ['En attente', 'Confirmée'])) {
            return back()->with('error', 'Cette réservation ne peut pas être annulée.');
        }
        $reservation->update(['statut' => 'Annulée']);
        $reservation->voiture->update(['statut' => 'Disponible']);
        return back()->with('success', 'Réservation annulée.');
    }
}
