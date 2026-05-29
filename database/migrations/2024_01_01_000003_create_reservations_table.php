<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('numero_reservation')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('voiture_id')->constrained()->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('nb_jours');
            $table->decimal('prix_total', 10, 2);
            $table->string('lieu_prise_en_charge');
            $table->string('lieu_retour');
            $table->enum('statut', ['En attente', 'Confirmée', 'En cours', 'Terminée', 'Annulée'])->default('En attente');
            $table->enum('mode_paiement', ['Espèces', 'Carte bancaire', 'Virement'])->nullable();
            $table->enum('statut_paiement', ['Non payé', 'Partiel', 'Payé'])->default('Non payé');
            $table->decimal('caution', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
