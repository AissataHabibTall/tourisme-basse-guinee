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
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->integer('note');  // Note de l'avis
            $table->text('commentaire');  // Commentaire de l'avis
            $table->date('date');  // Date de l'avis
            $table->foreignId('utilisateur_id')->constrained()->onDelete('cascade');  // Clé étrangère vers Utilisateur
            $table->string('cible_type');  // Type de la cible (Lieu, Hébergement, etc.)
            $table->unsignedBigInteger('cible_id');  // Identifiant de la cible (polymorphique)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
