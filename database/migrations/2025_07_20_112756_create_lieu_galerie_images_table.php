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
        Schema::create('lieu_galerie_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lieu_touristique_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('lieu_touristique_id')
                ->references('id')
                ->on('lieu_touristiques')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lieu_galerie_images');
    }
};
