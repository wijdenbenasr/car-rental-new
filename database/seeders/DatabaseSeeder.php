<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Voiture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'            => 'Administrateur',
            'email'           => 'admin@drivenow.tn',
            'password'        => Hash::make('password'),
            'role'            => 'admin',
            'phone'           => '+216 71 000 000',
            'cin'             => '00000000',
            'permis_conduire' => 'N/A',
        ]);

        // Client de test
        User::create([
            'name'            => 'Ahmed Ben Ali',
            'email'           => 'client@drivenow.tn',
            'password'        => Hash::make('password'),
            'role'            => 'client',
            'phone'           => '+216 55 123 456',
            'cin'             => '12345678',
            'permis_conduire' => 'TN-2019-001',
        ]);

        // Voitures de démonstration
        $voitures = [
            ['marque'=>'Renault','modele'=>'Clio 5','annee'=>2023,'immatriculation'=>'TN-001-RS','couleur'=>'Blanc','categorie'=>'Économique','nb_places'=>5,'transmission'=>'Manuelle','carburant'=>'Essence','kilometrage'=>15000,'prix_par_jour'=>60,'statut'=>'Disponible','climatisation'=>'Oui','gps'=>'Non'],
            ['marque'=>'Peugeot','modele'=>'308','annee'=>2022,'immatriculation'=>'TN-002-RS','couleur'=>'Gris','categorie'=>'Compacte','nb_places'=>5,'transmission'=>'Automatique','carburant'=>'Diesel','kilometrage'=>28000,'prix_par_jour'=>80,'statut'=>'Disponible','climatisation'=>'Oui','gps'=>'Oui'],
            ['marque'=>'Toyota','modele'=>'RAV4','annee'=>2023,'immatriculation'=>'TN-003-RS','couleur'=>'Noir','categorie'=>'SUV','nb_places'=>5,'transmission'=>'Automatique','carburant'=>'Hybride','kilometrage'=>5000,'prix_par_jour'=>150,'statut'=>'Disponible','climatisation'=>'Oui','gps'=>'Oui'],
            ['marque'=>'Mercedes','modele'=>'Classe C','annee'=>2022,'immatriculation'=>'TN-004-RS','couleur'=>'Argent','categorie'=>'Luxe','nb_places'=>5,'transmission'=>'Automatique','carburant'=>'Essence','kilometrage'=>22000,'prix_par_jour'=>250,'statut'=>'Disponible','climatisation'=>'Oui','gps'=>'Oui'],
            ['marque'=>'Volkswagen','modele'=>'Golf 8','annee'=>2023,'immatriculation'=>'TN-005-RS','couleur'=>'Bleu','categorie'=>'Compacte','nb_places'=>5,'transmission'=>'Manuelle','carburant'=>'Diesel','kilometrage'=>12000,'prix_par_jour'=>90,'statut'=>'Disponible','climatisation'=>'Oui','gps'=>'Non'],
            ['marque'=>'Dacia','modele'=>'Sandero','annee'=>2022,'immatriculation'=>'TN-006-RS','couleur'=>'Rouge','categorie'=>'Économique','nb_places'=>5,'transmission'=>'Manuelle','carburant'=>'Essence','kilometrage'=>35000,'prix_par_jour'=>45,'statut'=>'Disponible','climatisation'=>'Oui','gps'=>'Non'],
        ];

        foreach ($voitures as $v) {
            Voiture::create(array_merge($v, ['description' => 'Véhicule en excellent état, régulièrement entretenu.']));
        }
    }
}
