<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilisateur_id');
            $table->string('element_type'); // ex: hebergement, guide
            $table->unsignedBigInteger('element_id');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('statut')->default('en_attente'); // <-- ajouté ici
            $table->timestamps();

            $table->foreign('utilisateur_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
