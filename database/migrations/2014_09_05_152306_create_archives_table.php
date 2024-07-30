<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('type', ['FICHIER', 'IMAGE', 'VIDEO'])->default('FICHIER');
            $table->enum('source', ['PP', 'CONSEILLER', 'ADMIN', 'MESSAGE'])->default('PP');
            $table->string('url');
            $table->unsignedBigInteger('projet')->nullable();
            $table->unsignedBigInteger('actualite')->nullable();
            $table->unsignedBigInteger('message')->nullable();
            $table->foreign('projet')->references('id')->on('projets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('actualite')->references('id')->on('actualites')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('message')->references('id')->on('messages')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('archives');
    }
}
