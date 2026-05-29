<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_reservation', 'user_id', 'voiture_id',
        'date_debut', 'date_fin', 'nb_jours', 'prix_total',
        'lieu_prise_en_charge', 'lieu_retour', 'statut',
        'mode_paiement', 'statut_paiement', 'caution', 'notes',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

    public static function generateNumero(): string
    {
        return 'RES-' . strtoupper(uniqid());
    }

    public function getStatutBadgeClass(): string
    {
        return match ($this->statut) {
            'En attente'  => 'badge-warning',
            'Confirmée'   => 'badge-info',
            'En cours'    => 'badge-primary',
            'Terminée'    => 'badge-success',
            'Annulée'     => 'badge-danger',
            default       => 'badge-secondary',
        };
    }
}
