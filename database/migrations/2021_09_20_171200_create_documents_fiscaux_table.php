<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsFiscauxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_fiscaux', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['DSF', 'COMPTE_EXPLOITATION', 'RCCM', 'CARTE_CONTRIBUABLE', 'ANR', 'ATTESTATION_DOMICILIATION_BANCAIRE'])->default('DSF');
            $table->string('document');
            $table->unsignedBigInteger('user');
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_fiscaux');
    }
}
