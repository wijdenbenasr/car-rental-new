<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('voitures', function (Blueprint $table) {
            $table->id();
            $table->string('marque');
            $table->string('modele');
            $table->year('annee');
            $table->string('immatriculation')->unique();
            $table->string('couleur');
            $table->enum('categorie', ['Économique', 'Compacte', 'Berline', 'SUV', 'Luxe', 'Utilitaire']);
            $table->integer('nb_places');
            $table->enum('transmission', ['Manuelle', 'Automatique']);
            $table->enum('carburant', ['Essence', 'Diesel', 'Électrique', 'Hybride']);
            $table->integer('kilometrage')->default(0);
            $table->decimal('prix_par_jour', 8, 2);
            $table->enum('statut', ['Disponible', 'Louée', 'Maintenance', 'Hors service'])->default('Disponible');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('climatisation')->default('Oui');
            $table->string('gps')->default('Non');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voitures');
    }
};
