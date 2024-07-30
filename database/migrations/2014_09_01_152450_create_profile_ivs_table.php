<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileIvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_investisseurs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['IGOLIDE', 'SANJASAWA', 'SAMAKAKA', 'ERE'])->default('IGOLIDE');
            $table->string('frais_abonnement');
            $table->unsignedBigInteger('montant_min');
            $table->unsignedBigInteger('montant_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_investisseurs');
    }
}
