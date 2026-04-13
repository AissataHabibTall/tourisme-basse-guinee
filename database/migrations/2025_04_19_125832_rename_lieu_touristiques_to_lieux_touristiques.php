<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameLieuTouristiquesToLieuxTouristiques extends Migration
{
    public function up()
    {
        Schema::rename('lieu_touristiques', 'lieux_touristiques');
    }

    public function down()
    {
        Schema::rename('lieux_touristiques', 'lieu_touristiques');
    }
}
