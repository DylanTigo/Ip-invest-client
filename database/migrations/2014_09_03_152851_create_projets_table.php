<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secteur')->nullable();
            $table->unsignedBigInteger('user');
            $table->enum('avancement', ['IDEE', 'PROTOTYPE', 'SUR_LE_MARCHE'])->default('IDEE');
            $table->enum('type', ['IP', 'AUTRE'])->default('AUTRE');
            $table->enum('etat', ['ATTENTE', 'ATTENTE_INFO_SUPPL', 'PUBLIE', 'VALIDE', 'COMPLET', 'ATTENTE_VALIDATION_ADMIN', 'ATTENTE_PAIEMENT', 'REJETE', 'CLOTURE'])->default('ATTENTE');
            $table->string('intitule');
            $table->string('folder')->nullable();
            $table->integer('taux_rentabilite')->nullable();
            $table->timestamp('date_debut')->nullable();
            $table->string('duree')->nullable();
            $table->integer('rsi')->nullable();
            $table->integer('ca_previsionnel')->nullable();
            $table->string('doc_presentation')->nullable();
            $table->string('pays_activite');
            $table->string('ville_activite');
            $table->string('site')->nullable();
            $table->text('description');
            $table->boolean('complet')->default(false);
            $table->integer('financement');
            $table->string('logo')->nullable();
            $table->foreign('secteur')->references('id')->on('secteurs')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('projets');
    }
}
