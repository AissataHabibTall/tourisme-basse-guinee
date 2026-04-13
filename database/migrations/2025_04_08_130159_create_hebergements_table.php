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
    Schema::create('hebergements', function (Blueprint $table) {
        $table->id();
        $table->string('nom');  // Nom de l'hébergement
        $table->string('type');  // Type de l'hébergement (hôtel, auberge, etc.)
        $table->string('adresse');  // Adresse de l'hébergement
        $table->decimal('prixParNuit', 8, 2);  // Prix par nuit avec 2 décimales
        $table->boolean('disponibilite');  // Indique si l'hébergement est disponible
        $table->string('contact');  // Contact de l'hébergement
        $table->decimal('noteMoyenne', 3, 2);  // Note moyenne avec 2 décimales
        $table->string('image_url')->nullable();  // Colonne image_url, nullable car tous les hébergements n'ont peut-être pas d'image
        $table->json('galerie_images_hebergement')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hebergements');
    }
};
