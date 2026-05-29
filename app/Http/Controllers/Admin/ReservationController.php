<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Voiture;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'voiture']);

        if ($request->filled('statut'))  $query->where('statut', $request->statut);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('numero_reservation', 'like', "%$s%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$s%"))
                  ->orWhereHas('voiture', fn($v) => $v->where('marque', 'like', "%$s%")->orWhere('modele', 'like', "%$s%"));
            });
        }

        $reservations = $query->latest()->paginate(10);
        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'voiture']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function create()
    {
        $clients  = User::where('role', 'client')->get();
        $voitures = Voiture::where('statut', 'Disponible')->get();
        return view('admin.reservations.create', compact('clients', 'voitures'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'               => 'required|exists:users,id',
            'voiture_id'            => 'required|exists:voitures,id',
            'date_debut'            => 'required|date|after_or_equal:today',
            'date_fin'              => 'required|date|after:date_debut',
            'lieu_prise_en_charge'  => 'required|string',
            'lieu_retour'           => 'required|string',
            'mode_paiement'         => 'nullable|in:Espèces,Carte bancaire,Virement',
            'statut_paiement'       => 'required|in:Non payé,Partiel,Payé',
            'caution'               => 'required|numeric|min:0',
            'notes'                 => 'nullable|string',
        ]);

        $voiture   = Voiture::findOrFail($data['voiture_id']);
        $nb_jours  = \Carbon\Carbon::parse($data['date_debut'])->diffInDays($data['date_fin']);
        $prix_total = $nb_jours * $voiture->prix_par_jour;

        $reservation = Reservation::create(array_merge($data, [
            'numero_reservation' => Reservation::generateNumero(),
            'nb_jours'           => $nb_jours,
            'prix_total'         => $prix_total,
            'statut'             => 'Confirmée',
        ]));

        $voiture->update(['statut' => 'Louée']);

        return redirect()->route('admin.reservations.show', $reservation)->with('success', 'Réservation créée !');
    }

    public function updateStatut(Request $request, Reservation $reservation)
    {
        $request->validate(['statut' => 'required|in:En attente,Confirmée,En cours,Terminée,Annulée']);
        $reservation->update(['statut' => $request->statut]);

        // Mettre à jour le statut de la voiture
        if (in_array($request->statut, ['Terminée', 'Annulée'])) {
            $reservation->voiture->update(['statut' => 'Disponible']);
        } elseif ($request->statut === 'En cours') {
            $reservation->voiture->update(['statut' => 'Louée']);
        }

        return back()->with('success', 'Statut mis à jour !');
    }

    public function destroy(Reservation $reservation)
    {
        if (in_array($reservation->statut, ['En attente', 'Confirmée'])) {
            $reservation->voiture->update(['statut' => 'Disponible']);
        }
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Réservation supprimée.');
    }
}
