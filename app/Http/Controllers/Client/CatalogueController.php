<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Voiture;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $query = Voiture::where('statut', 'Disponible');

        if ($request->filled('categorie'))    $query->where('categorie', $request->categorie);
        if ($request->filled('transmission')) $query->where('transmission', $request->transmission);
        if ($request->filled('carburant'))    $query->where('carburant', $request->carburant);
        if ($request->filled('prix_max'))     $query->where('prix_par_jour', '<=', $request->prix_max);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('marque', 'like', "%$s%")->orWhere('modele', 'like', "%$s%"));
        }

        $voitures = $query->paginate(9);
        return view('client.catalogue', compact('voitures'));
    }

    public function show(Voiture $voiture)
    {
        return view('client.voiture-detail', compact('voiture'));
    }
}
