<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenementPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evenement_partner', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partenaire_image')->nullable();
                $table->foreign('partenaire_image')->references('id')->on('partenaires')->onDelete('set null');
                $table->unsignedBigInteger('evenement_id')->nullable();
                $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('set null');
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
        Schema::dropIfExists('evenement_partner');
    }
}
