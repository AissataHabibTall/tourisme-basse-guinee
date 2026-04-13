<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guide_touristiques', function (Blueprint $table) {
            $table->id();
            $table->string('nom');  // Nom du guide touristique
            $table->string('languesParlees');  // Langues parlées par le guide
            $table->string('zoneCouverte');  // Zone géographique couverte par le guide
            $table->string('experience');  // Expérience du guide
            $table->decimal('tarifJournalier', 8, 2);  // Tarif journalier
            $table->string('contact');  // Contact du guide
            $table->boolean('disponibilite');  // Disponibilité du guide
            $table->timestamps();

            // Clé étrangère vers la table utilisateurs
            $table->foreign('utilisateur_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_touristiques');
    }
};
