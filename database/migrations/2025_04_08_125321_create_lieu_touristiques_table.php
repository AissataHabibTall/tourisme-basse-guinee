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
        Schema::create('lieu_touristiques', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->string('adresse');
            $table->string('type');
            $table->string('coordonneesGPS');
            $table->string('image')->nullable();
            $table->json('galerie_images')->nullable(); // <-- Nouveau champ pour la galerie d'images
            $table->decimal('tarifEntree', 8, 2);
            $table->string('horairesOuverture');
            $table->string('accessibilite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lieu_touristiques');
    }
};
