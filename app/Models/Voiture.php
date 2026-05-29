<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{
    use HasFactory;

    protected $fillable = [
        'marque', 'modele', 'annee', 'immatriculation', 'couleur',
        'categorie', 'nb_places', 'transmission', 'carburant',
        'kilometrage', 'prix_par_jour', 'statut', 'description',
        'image', 'climatisation', 'gps',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function isDisponible(): bool
    {
        return $this->statut === 'Disponible';
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('uploads/voitures/' . $this->image))) {
            return asset('uploads/voitures/' . $this->image);
        }
        return asset('images/car-default.png');
    }

    public function scopeDisponibles($query)
    {
        return $query->where('statut', 'Disponible');
    }

    public function scopeByCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }
}
