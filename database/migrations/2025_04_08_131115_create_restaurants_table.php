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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');  // Nom du restaurant
            $table->string('specialites');  // Spécialités du restaurant
            $table->string('adresse');  // Adresse du restaurant
            $table->decimal('tarifMoyen', 8, 2);  // Tarif moyen
            $table->string('contact');  // Contact du restaurant
            $table->decimal('noteMoyenne', 3, 2);  // Note moyenne
            $table->json('galerie_images_restaurant')->nullable();
            $table->foreignId('lieu_touristique_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
