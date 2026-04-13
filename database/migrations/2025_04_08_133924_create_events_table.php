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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('titre'); // Titre de l'événement
            $table->text('description'); // Description de l'événement
            $table->dateTime('date_debut'); // Date de début de l'événement
            $table->dateTime('date_fin'); // Date de fin de l'événement
            $table->string('lieu'); // Lieu de l'événement
            $table->decimal('prix', 10, 2)->nullable(); // Prix de l'événement (optionnel)
            $table->string('image')->nullable(); // Image principale de l'événement
            $table->json('galerie_images_event')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
