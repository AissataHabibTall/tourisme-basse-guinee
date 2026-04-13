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
        Schema::create('circuit_touristiques', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Nom du circuit touristique
            $table->text('description'); // Description du circuit touristique
            $table->decimal('prix', 10, 2); // Prix du circuit
            $table->date('dateDebut'); // Date de début du circuit
            $table->date('dateFin'); // Date de fin du circuit
            $table->string('statut'); // Statut du circuit (disponible, indisponible, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circuit_touristiques');
    }
};
