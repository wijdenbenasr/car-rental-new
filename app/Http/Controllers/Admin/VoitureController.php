<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VoitureController extends Controller
{
    public function index(Request $request)
    {
        $query = Voiture::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('marque', 'like', "%$s%")
                  ->orWhere('modele', 'like', "%$s%")
                  ->orWhere('immatriculation', 'like', "%$s%");
            });
        }
        if ($request->filled('statut'))    $query->where('statut', $request->statut);
        if ($request->filled('categorie')) $query->where('categorie', $request->categorie);

        $voitures = $query->latest()->paginate(10);
        return view('admin.voitures.index', compact('voitures'));
    }

    public function create()
    {
        return view('admin.voitures.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'marque'          => 'required|string|max:100',
            'modele'          => 'required|string|max:100',
            'annee'           => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'immatriculation' => 'required|string|unique:voitures',
            'couleur'         => 'required|string',
            'categorie'       => 'required|in:Économique,Compacte,Berline,SUV,Luxe,Utilitaire',
            'nb_places'       => 'required|integer|min:2|max:9',
            'transmission'    => 'required|in:Manuelle,Automatique',
            'carburant'       => 'required|in:Essence,Diesel,Électrique,Hybride',
            'kilometrage'     => 'required|integer|min:0',
            'prix_par_jour'   => 'required|numeric|min:0',
            'statut'          => 'required|in:Disponible,Louée,Maintenance,Hors service',
            'climatisation'   => 'required',
            'gps'             => 'required',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('voitures', 'public');
        }

        Voiture::create($data);
        return redirect()->route('admin.voitures.index')->with('success', 'Voiture ajoutée avec succès !');
    }

    public function edit(Voiture $voiture)
    {
        return view('admin.voitures.edit', compact('voiture'));
    }

    public function update(Request $request, Voiture $voiture)
    {
        $data = $request->validate([
            'marque'          => 'required|string|max:100',
            'modele'          => 'required|string|max:100',
            'annee'           => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'immatriculation' => 'required|string|unique:voitures,immatriculation,' . $voiture->id,
            'couleur'         => 'required|string',
            'categorie'       => 'required',
            'nb_places'       => 'required|integer',
            'transmission'    => 'required',
            'carburant'       => 'required',
            'kilometrage'     => 'required|integer|min:0',
            'prix_par_jour'   => 'required|numeric|min:0',
            'statut'          => 'required',
            'climatisation'   => 'required',
            'gps'             => 'required',
            'description'     => 'nullable|string',
            'image'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($voiture->image) Storage::disk('public')->delete($voiture->image);
            $data['image'] = $request->file('image')->store('voitures', 'public');
        }

        $voiture->update($data);
        return redirect()->route('admin.voitures.index')->with('success', 'Voiture modifiée avec succès !');
    }

    public function destroy(Voiture $voiture)
    {
        if ($voiture->image) Storage::disk('public')->delete($voiture->image);
        $voiture->delete();
        return redirect()->route('admin.voitures.index')->with('success', 'Voiture supprimée.');
    }

    public function show(Voiture $voiture)
    {
        $voiture->load('reservations.user');
        return view('admin.voitures.show', compact('voiture'));
    }
}
