<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
            $table->string('nom_complet');
            $table->string('telephone');
            $table->string('email');
            $table->string('photo')->nullable();            
            $table->string('cni')->nullable();          
            $table->string('pays')->nullable();          
            $table->string('ville')->nullable();          
            $table->string('profession')->nullable();            
            $table->timestamp('date_naissance')->nullable();
            $table->text('parcours')->nullable();
            $table->unsignedBigInteger('user')->nullable();
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
        Schema::dropIfExists('membres');
    }
}
